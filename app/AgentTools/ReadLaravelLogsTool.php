<?php

namespace App\AgentTools;

use LarAgent\Core\Contracts\DataModel;
use LarAgent\Tool;
use Illuminate\Support\Facades\File;

class ReadLaravelLogsTool extends Tool
{
    protected string $name = 'read_laravel_logs';

    protected string $description = 'قراءة وفحص وتصفية سجلات أخطاء لارافيل (storage/logs/laravel.log) بطريقة آمنة للذاكرة، مع تصفية مستويات الأخطاء الحرجة (ERROR, CRITICAL, ALERT, EMERGENCY)، واستخراج السبب الجذري والملفات المتسببة مع استبعاد الضجيج.';

    protected array $properties = [
        'filter_level' => [
            'type' => 'string',
            'description' => 'مستوى تصفية الأخطاء المطلوب: all_errors (جميع الأخطاء الحرجة والعامة), critical_only (أخطاء CRITICAL و ALERT و EMERGENCY فقط), database_errors (أخطاء قواعد البيانات SQLSTATE والـ Migrations), connection_errors (أخطاء cURL وبوابات الدفع وشبكات الـ API), all_logs (قراءة السجلات دون تصفية)',
            'enum' => ['all_errors', 'critical_only', 'database_errors', 'connection_errors', 'all_logs'],
        ],
        'search_keyword' => [
            'type' => 'string',
            'description' => 'كلمة مفتاحية للبحث داخل رسائل الخطأ (مثال: SQLSTATE, cURL, Chargily, Tenancy, Class not found, Call to a member function).',
        ],
        'max_entries' => [
            'type' => 'integer',
            'description' => 'الحد الأقصى لعدد الأخطاء الفريدة المراد إرجاعها (الافتراضي: 15).',
        ],
    ];

    protected array $required = [];

    protected array $metaData = [];

    protected function handle(array|DataModel $input): mixed
    {
        $filterLevel = is_array($input) ? ($input['filter_level'] ?? 'all_errors') : ($input->filter_level ?? 'all_errors');
        $searchKeyword = is_array($input) ? ($input['search_keyword'] ?? null) : ($input->search_keyword ?? null);
        $maxEntries = is_array($input) ? (int)($input['max_entries'] ?? 15) : (int)($input->max_entries ?? 15);
        if ($maxEntries <= 0 || $maxEntries > 50) {
            $maxEntries = 15;
        }

        $logPath = storage_path('logs/laravel.log');

        // إذا لم يكن الملف الأساسي موجوداً، نبحث عن أحدث سجل يومي laravel-YYYY-MM-DD.log
        if (!File::exists($logPath) || File::size($logPath) === 0) {
            $dailyLogs = glob(storage_path('logs/laravel-*.log'));
            if (!empty($dailyLogs)) {
                rsort($dailyLogs);
                $logPath = $dailyLogs[0];
            } else {
                return json_encode([
                    'status' => 'empty',
                    'message' => 'ملف سجلات لارافيل غير موجود أو فارغ تماماً.',
                    'errors_found' => 0,
                    'errors' => [],
                ], JSON_UNESCAPED_UNICODE);
            }
        }

        $fileSize = filesize($logPath);
        // قراءة ذيل الملف بحجم أقصاه 300 كيلوبايت لتوفير الذاكرة وسرعة المعالجة
        $readBytes = min($fileSize, 300 * 1024);

        $fp = fopen($logPath, 'rb');
        if (!$fp) {
            return json_encode([
                'status' => 'error',
                'message' => 'تعذر فتح ملف السجل للقراءة.',
            ], JSON_UNESCAPED_UNICODE);
        }

        fseek($fp, -$readBytes, SEEK_END);
        $rawChunk = fread($fp, $readBytes);
        fclose($fp);

        if (empty($rawChunk)) {
            return json_encode([
                'status' => 'empty',
                'message' => 'لم يتم العثور على أية سجلات في ذيل الملف.',
                'errors_found' => 0,
                'errors' => [],
            ], JSON_UNESCAPED_UNICODE);
        }

        // تقسيم السجلات بنمط استخراج رسائل PSR-3
        // [YYYY-MM-DD HH:MM:SS] environment.LEVEL: Message
        $pattern = '/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] ([a-zA-Z0-9_-]+)\.([A-Z]+): (.*?)(?=(?:\R\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\]|\z))/sm';
        preg_match_all($pattern, $rawChunk, $matches, PREG_SET_ORDER);

        if (empty($matches)) {
            return json_encode([
                'status' => 'clean',
                'message' => 'لا توجد سجلات مطابقة في الجزء الأخير من ملف السجل.',
                'errors_found' => 0,
                'errors' => [],
            ], JSON_UNESCAPED_UNICODE);
        }

        $parsedErrors = [];
        $totalMatched = 0;

        // تحديد المستويات المقبولة حسب الفلتر
        $allowedLevels = match ($filterLevel) {
            'critical_only' => ['CRITICAL', 'ALERT', 'EMERGENCY'],
            'all_logs' => ['EMERGENCY', 'ALERT', 'CRITICAL', 'ERROR', 'WARNING', 'NOTICE', 'INFO', 'DEBUG'],
            default => ['ERROR', 'CRITICAL', 'ALERT', 'EMERGENCY'],
        };

        // معالجة السجلات من الأحدث إلى الأقدم
        $reversedMatches = array_reverse($matches);

        foreach ($reversedMatches as $entry) {
            $timestamp = $entry[1];
            $environment = $entry[2];
            $level = strtoupper($entry[3]);
            $body = trim($entry[4]);

            // التحقق من المستوى
            if (!in_array($level, $allowedLevels)) {
                continue;
            }

            // فلتر أخطاء قواعد البيانات
            if ($filterLevel === 'database_errors') {
                if (!str_contains($body, 'SQLSTATE') && !str_contains($body, 'QueryException') && !str_contains($body, 'PDOException')) {
                    continue;
                }
            }

            // فلتر أخطاء الاتصالات والـ API
            if ($filterLevel === 'connection_errors') {
                if (!str_contains($body, 'cURL error') && !str_contains($body, 'ConnectionException') && !str_contains($body, 'RequestException') && !str_contains($body, 'ClientException')) {
                    continue;
                }
            }

            // فلتر الكلمة المفتاحية إذا تم تحديدها
            if (!empty($searchKeyword)) {
                if (stripos($body, $searchKeyword) === false) {
                    continue;
                }
            }

            $totalMatched++;

            // استخراج السطر الأول كعنوان للخطأ
            $lines = explode("\n", $body);
            $mainMessage = trim($lines[0]);
            // إزالة وسوم JSON إن وجدت في نهاية السطر الأول
            if (mb_strlen($mainMessage) > 300) {
                $mainMessage = mb_substr($mainMessage, 0, 300) . '...';
            }

            // استخراج الاستثناء الرئيسي
            $exceptionClass = 'Standard Exception';
            if (preg_match('/([a-zA-Z0-9_\\\\]+Exception)/', $body, $excMatch)) {
                $exceptionClass = $excMatch[1];
            } elseif (preg_match('/PHP (Parse error|Fatal error)/', $body, $excMatch)) {
                $exceptionClass = $excMatch[0];
            }

            // استخراج أول ملف متسبب من داخل مجلد المشروع (app/ أو routes/ أو database/)
            $appFrame = 'Unknown';
            if (preg_match('/at\s+([A-Za-z]:[\\\\\/][^:]+):(\d+)/', $body, $frameMatch)) {
                $appFrame = $frameMatch[1] . ':' . $frameMatch[2];
            } elseif (preg_match('/#\d+\s+([A-Za-z]:[\\\\\/][^:]+):(\d+)/', $body, $frameMatch)) {
                $appFrame = $frameMatch[1] . ':' . $frameMatch[2];
            }

            // مفتاح التجميع لمنع التكرار (Deduplication)
            $dedupKey = md5($level . $exceptionClass . $mainMessage);

            if (isset($parsedErrors[$dedupKey])) {
                $parsedErrors[$dedupKey]['occurrences']++;
                $parsedErrors[$dedupKey]['first_seen'] = $timestamp; // بما أننا نقرأ بالعكس فالأقدم يصل لاحقاً
            } else {
                if (count($parsedErrors) >= $maxEntries) {
                    continue;
                }

                // استخراج إطارات الـ Stack Trace التابعة لـ app/ فقط
                $relevantAppFrames = [];
                foreach ($lines as $line) {
                    if (str_contains($line, '/app/') || str_contains($line, '\\app\\') || str_contains($line, 'App\\')) {
                        $cleanedLine = trim(str_replace(base_path() . DIRECTORY_SEPARATOR, '', $line));
                        if (!empty($cleanedLine)) {
                            $relevantAppFrames[] = mb_substr($cleanedLine, 0, 180);
                        }
                    }
                    if (count($relevantAppFrames) >= 3) {
                        break;
                    }
                }

                $parsedErrors[$dedupKey] = [
                    'level' => $level,
                    'environment' => $environment,
                    'exception_type' => $exceptionClass,
                    'message' => $mainMessage,
                    'source_location' => str_replace(base_path() . DIRECTORY_SEPARATOR, '', $appFrame),
                    'occurrences' => 1,
                    'last_seen' => $timestamp,
                    'first_seen' => $timestamp,
                    'app_trace' => $relevantAppFrames,
                ];
            }
        }

        $errorList = array_values($parsedErrors);

        return json_encode([
            'status' => 'success',
            'log_file' => str_replace(base_path() . DIRECTORY_SEPARATOR, '', $logPath),
            'log_size_kb' => round($fileSize / 1024, 2),
            'filter_level' => $filterLevel,
            'search_keyword' => $searchKeyword,
            'total_matching_events' => $totalMatched,
            'unique_errors_returned' => count($errorList),
            'errors' => $errorList,
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}

