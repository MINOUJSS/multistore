<?php

namespace App\AgentTools;

use LarAgent\Core\Contracts\DataModel;
use LarAgent\Tool;
use Illuminate\Support\Facades\File;

class ReadFrontendJsLogsTool extends Tool
{
    protected string $name = 'read_frontend_js_logs';

    protected string $description = 'قراءة وتحليل أخطاء الـ JavaScript والمتصفح (Console Errors)، وتفكيك أخطاء Alpine.js، طلبات الـ Fetch/AJAX، وأخطاء الـ DOM وتحديد الملفات البرمجية المتسببة في قوالب Blade وأصول الـ JS.';

    protected array $properties = [
        'source_type' => [
            'type' => 'string',
            'description' => 'مصدر أخطاء الواجهة: auto_detect (فحص ملفات السجلات تلقائياً), raw_console_text (تحليل نص أخطاء منسوخ مباشرة من كونسول المتصفح DevTools), ajax_errors_in_laravel_log (استخراج أخطاء الـ AJAX والـ CSRF 419 من سجلات السيرفر)',
            'enum' => ['auto_detect', 'raw_console_text', 'ajax_errors_in_laravel_log'],
        ],
        'raw_console_text' => [
            'type' => 'string',
            'description' => 'نص أخطاء الكونسول المنسوخ من المتصفح (مثال: Uncaught TypeError: Cannot read properties of undefined, Alpine Expression Error: isModalOpen is not defined, 419 Page Expired).',
        ],
        'error_category' => [
            'type' => 'string',
            'description' => 'تصنيف المشكلة المراد التركيز عليها: all (جميع الأخطاء), alpine_js (أخطاء متغيرات وتعبيرات ألبين), dom_type_errors (أخطاء TypeError و null elements), fetch_network (أخطاء الـ AJAX والـ CSRF والشبكة)',
            'enum' => ['all', 'alpine_js', 'dom_type_errors', 'fetch_network'],
        ],
    ];

    protected array $required = [];

    protected array $metaData = [];

    protected function handle(array|DataModel $input): mixed
    {
        $sourceType = is_array($input) ? ($input['source_type'] ?? 'auto_detect') : ($input->source_type ?? 'auto_detect');
        $rawText = is_array($input) ? ($input['raw_console_text'] ?? null) : ($input->raw_console_text ?? null);
        $category = is_array($input) ? ($input['error_category'] ?? 'all') : ($input->error_category ?? 'all');

        // إذا تم تمرير نص كونسول خام مباشرة
        if (!empty($rawText) || $sourceType === 'raw_console_text') {
            return $this->parseRawConsoleText($rawText ?? '', $category);
        }

        // إذا طلب فحص أخطاء الـ AJAX في سجلات لارافيل
        if ($sourceType === 'ajax_errors_in_laravel_log') {
            return $this->scanLaravelLogForAjaxErrors();
        }

        // الافتراضي (auto_detect): فحص ملف javascript.log ثم frontend.log
        $jsLogPath = storage_path('logs/javascript.log');
        $frontendLogPath = storage_path('logs/frontend.log');

        $targetFile = null;
        if (File::exists($jsLogPath) && File::size($jsLogPath) > 0) {
            $targetFile = $jsLogPath;
        } elseif (File::exists($frontendLogPath) && File::size($frontendLogPath) > 0) {
            $targetFile = $frontendLogPath;
        }

        if ($targetFile) {
            $fileSize = filesize($targetFile);
            $readBytes = min($fileSize, 200 * 1024);
            $fp = fopen($targetFile, 'rb');
            fseek($fp, -$readBytes, SEEK_END);
            $content = fread($fp, $readBytes);
            fclose($fp);

            return $this->parseRawConsoleText($content, $category, basename($targetFile));
        }

        // في حال عدم وجود ملف مخصص بعد، نفحص سجلات لارافيل بحثاً عن أخطاء الـ AJAX والـ CSRF
        $ajaxResults = $this->scanLaravelLogForAjaxErrors();
        $decodedAjax = json_decode($ajaxResults, true);

        if (!empty($decodedAjax['errors_found']) && $decodedAjax['errors_found'] > 0) {
            return $ajaxResults;
        }

        return json_encode([
            'status' => 'info',
            'message' => 'لم يتم العثور على أخطاء واجهة مسجلة في ملفات storage/logs/javascript.log أو سجلات الـ AJAX الحديثة. يمكنك تمرير نصوص أخطاء الـ DevTools Console عبر خاصية raw_console_text ليقوم الوكيل بتحليلها فورياً.',
            'supported_categories' => ['alpine_js', 'dom_type_errors', 'fetch_network', 'csrf_page_expired'],
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    protected function parseRawConsoleText(string $text, string $category, ?string $sourceFile = null): string
    {
        if (empty(trim($text))) {
            return json_encode([
                'status' => 'empty',
                'message' => 'النص المقدم لفحص أخطاء الـ JavaScript فارغ.',
            ], JSON_UNESCAPED_UNICODE);
        }

        $lines = preg_split('/\r\n|\r|\n/', $text);
        $parsedIssues = [];

        foreach ($lines as $line) {
            $trimmed = trim($line);
            if (empty($trimmed)) {
                continue;
            }

            // فحص أخطاء Alpine.js
            if (stripos($trimmed, 'Alpine Expression Error') !== false || stripos($trimmed, 'Alpine Error') !== false) {
                if ($category === 'all' || $category === 'alpine_js') {
                    $parsedIssues[] = [
                        'type' => 'Alpine.js Expression Error',
                        'severity' => 'High',
                        'raw_message' => $trimmed,
                        'diagnostic' => 'تعطل متغير أو تعبير منطقي داخل سمات Alpine.js (مثل x-data, x-show, @click, x-model).',
                    ];
                }
            }
            // فحص أخطاء TypeError و undefined
            elseif (stripos($trimmed, 'TypeError') !== false || stripos($trimmed, 'Cannot read properties of') !== false || stripos($trimmed, 'is not a function') !== false) {
                if ($category === 'all' || $category === 'dom_type_errors') {
                    $parsedIssues[] = [
                        'type' => 'JavaScript TypeError',
                        'severity' => 'High',
                        'raw_message' => $trimmed,
                        'diagnostic' => 'محاولة استدعاء دالة أو قراءة خاصية على عنصر فارغ (null/undefined)، غالباً بسبب عدم وجود العنصر في DOM أو تشغيل الكود قبل تحميل الصفحة.',
                    ];
                }
            }
            // فحص أخطاء CSRF والـ Fetch و HTTP 419
            elseif (stripos($trimmed, '419') !== false || stripos($trimmed, 'Page Expired') !== false || stripos($trimmed, 'Failed to fetch') !== false || stripos($trimmed, 'NetworkError') !== false) {
                if ($category === 'all' || $category === 'fetch_network') {
                    $parsedIssues[] = [
                        'type' => 'Network & CSRF Error',
                        'severity' => 'Critical',
                        'raw_message' => $trimmed,
                        'diagnostic' => 'فشل طلب AJAX/Fetch بسبب غياب أو انتهاء توكن الحماية CSRF Token، أو انقطاع اتصال الشبكة.',
                    ];
                }
            }
            // فحص أخطاء Syntax و Parsing
            elseif (stripos($trimmed, 'SyntaxError') !== false || stripos($trimmed, 'Unexpected token') !== false) {
                if ($category === 'all') {
                    $parsedIssues[] = [
                        'type' => 'Syntax / JSON Parsing Error',
                        'severity' => 'Medium',
                        'raw_message' => $trimmed,
                        'diagnostic' => 'خطأ صياغي في أكواد الـ JavaScript أو محاولة تفكيك JSON.parse لاستجابة سيرفر غير صالحة (مثل إعادة HTML عند حدوث خطأ 500).',
                    ];
                }
            }
            // استخراج إشارات الملفات وأرقام الأسطر
            elseif (preg_match('/at\s+([A-Za-z0-9_\-\.\/\\\]+\.(?:blade\.php|js|html)):(\d+)(?::(\d+))?/', $trimmed, $locMatch)) {
                if (!empty($parsedIssues)) {
                    $lastIdx = count($parsedIssues) - 1;
                    if (empty($parsedIssues[$lastIdx]['location'])) {
                        $parsedIssues[$lastIdx]['location'] = $locMatch[1] . ' (Line: ' . $locMatch[2] . ')';
                    }
                }
            }
        }

        return json_encode([
            'status' => 'success',
            'source' => $sourceFile ?? 'raw_console_input',
            'total_issues_detected' => count($parsedIssues),
            'category_filter' => $category,
            'issues' => array_slice($parsedIssues, 0, 15),
            'full_raw_snippet_length' => mb_strlen($text),
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    protected function scanLaravelLogForAjaxErrors(): string
    {
        $logPath = storage_path('logs/laravel.log');
        if (!File::exists($logPath) || File::size($logPath) === 0) {
            return json_encode([
                'status' => 'empty',
                'message' => 'ملف سجلات لارافيل غير موجود.',
                'errors_found' => 0,
            ], JSON_UNESCAPED_UNICODE);
        }

        $fileSize = filesize($logPath);
        $readBytes = min($fileSize, 200 * 1024);
        $fp = fopen($logPath, 'rb');
        fseek($fp, -$readBytes, SEEK_END);
        $rawChunk = fread($fp, $readBytes);
        fclose($fp);

        $lines = explode("\n", $rawChunk);
        $ajaxErrors = [];

        foreach ($lines as $line) {
            if (str_contains($line, 'TokenMismatchException') || str_contains($line, 'CSRF') || str_contains($line, '419')) {
                $ajaxErrors[] = [
                    'type' => 'CSRF Token Mismatch (HTTP 419)',
                    'severity' => 'Critical',
                    'line' => trim(mb_substr($line, 0, 200)),
                    'impact' => 'تعطل طلبات الـ AJAX أو نماذج الواجهة بسبب انتهاء الجلسة أو غياب X-CSRF-TOKEN.',
                ];
            }
        }

        return json_encode([
            'status' => 'success',
            'source' => 'storage/logs/laravel.log (AJAX & CSRF Scan)',
            'errors_found' => count($ajaxErrors),
            'errors' => array_slice($ajaxErrors, 0, 10),
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}

