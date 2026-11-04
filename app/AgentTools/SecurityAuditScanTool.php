<?php

namespace App\AgentTools;

use LarAgent\Core\Contracts\DataModel;
use LarAgent\Tool;
use Illuminate\Support\Facades\File;

class SecurityAuditScanTool extends Tool
{
    protected string $name = 'security_audit_scan';

    protected string $description = 'أداة الفحص الأمني الساكن (Static AppSec Scanner) لكشف الثغرات الأمنية في كود لارافيل وقوالب Blade ومسارات الـ Routes (مثل SQL Injection, XSS, CSRF, Mass Assignment, صلاحيات الـ Middleware، وأمان رفع الملفات).';

    protected array $properties = [
        'scan_target' => [
            'type' => 'string',
            'description' => 'نوع الهدف المراد تدقيقه أمنياً: code_snippet (فحص كود أو دالة معينة مباشرة), file_path (فحص ملف معين مثل Controller أو Blade أو Route), route_module (فحص أحد ملفات التوجيه في routes/modules/v1/)',
            'enum' => ['code_snippet', 'file_path', 'route_module'],
        ],
        'target_path' => [
            'type' => 'string',
            'description' => 'مسار الملف عند اختيار file_path أو route_module (مثال: routes/modules/v1/seller.php, app/Http/Controllers/Admins/Admin/AiMarketingController.php, resources/views/admins/admin/ai_marketing/index.blade.php).',
        ],
        'code_snippet' => [
            'type' => 'string',
            'description' => 'النص البرمجي الخام المراد تدقيقه أمنياً عند اختيار code_snippet.',
        ],
        'vulnerability_scope' => [
            'type' => 'string',
            'description' => 'نطاق الفحص الأمني: all_vulnerabilities (جميع التهديدات), sql_injection (حقن الاستعلامات), xss_sanitization (حقن نصوص الواجهة), csrf_and_auth_middleware (صلاحيات وحماية المسارات والـ CSRF), mass_assignment (الإسناد الجماعي والتحقق)',
            'enum' => ['all_vulnerabilities', 'sql_injection', 'xss_sanitization', 'csrf_and_auth_middleware', 'mass_assignment'],
        ],
    ];

    protected array $required = ['scan_target'];

    protected array $metaData = [];

    protected function handle(array|DataModel $input): mixed
    {
        $target = is_array($input) ? ($input['scan_target'] ?? 'code_snippet') : ($input->scan_target ?? 'code_snippet');
        $path = is_array($input) ? ($input['target_path'] ?? '') : ($input->target_path ?? '');
        $snippet = is_array($input) ? ($input['code_snippet'] ?? '') : ($input->code_snippet ?? '');
        $scope = is_array($input) ? ($input['vulnerability_scope'] ?? 'all_vulnerabilities') : ($input->vulnerability_scope ?? 'all_vulnerabilities');

        $contentToScan = '';
        $sourceName = '';

        if ($target === 'code_snippet') {
            if (empty(trim($snippet))) {
                return json_encode([
                    'status' => 'error',
                    'message' => 'الكود البرمجي المراد تدقيقه أمنياً فارغ.',
                ], JSON_UNESCAPED_UNICODE);
            }
            $contentToScan = $snippet;
            $sourceName = 'Code Snippet Input';
        } else {
            if (empty(trim($path))) {
                $path = 'routes/modules/v1/admin.php'; // مسار افتراضي عند عدم التحديد
            }

            $fullPath = base_path($path);
            if (!File::exists($fullPath)) {
                return json_encode([
                    'status' => 'error',
                    'message' => "الملف المطلوب غير موجود في المسار: {$path}",
                ], JSON_UNESCAPED_UNICODE);
            }

            $contentToScan = File::get($fullPath);
            $sourceName = str_replace(base_path() . DIRECTORY_SEPARATOR, '', $fullPath);
        }

        return $this->performStaticScan($contentToScan, $sourceName, $scope);
    }

    protected function performStaticScan(string $code, string $source, string $scope): string
    {
        $findings = [];
        $lines = explode("\n", $code);

        foreach ($lines as $index => $line) {
            $lineNum = $index + 1;
            $trimmed = trim($line);
            if (empty($trimmed) || str_starts_with($trimmed, '//') || str_starts_with($trimmed, '#') || str_starts_with($trimmed, '*')) {
                continue;
            }

            // 1. فحص SQL Injection
            if ($scope === 'all_vulnerabilities' || $scope === 'sql_injection') {
                if (preg_match('/(whereRaw|selectRaw|orderByRaw|havingRaw|DB::raw)\s*\([^)]*\$[^)]*\)/', $trimmed)) {
                    // إذا كان الاستعلام يحتوي على دمج متغيرات بدون مصفوفة bindings [ ]
                    if (str_contains($trimmed, '.') && !str_contains($trimmed, '?') && !preg_match('/,\s*\[/', $trimmed)) {
                        $findings[] = [
                            'type' => 'SQL Injection (Raw Query Interpolation)',
                            'severity' => 'Critical',
                            'line' => $lineNum,
                            'code_excerpt' => mb_substr($trimmed, 0, 160),
                            'owASP_category' => 'A03:2021-Injection',
                            'description' => 'استخدام دمج مباشر للسلاسل النصية والمتغيرات داخل استعلام خام DB::raw دون استخدام PDO Parameter Bindings.',
                            'remediation' => 'استبدل دمج المتغيرات بعلامات الاستفهام ? وتمرير المتغيرات ضمن مصفوفة Bindings ثانية، أو اعتمد على Eloquent ORM المباشر.',
                        ];
                    }
                }
            }

            // 2. فحص XSS (Unescaped Blade Output)
            if ($scope === 'all_vulnerabilities' || $scope === 'xss_sanitization') {
                if (preg_match('/\{!!\s*(\$(?!errors|_|slot|csrf|attributes|message)[\w\->\[\]\'"]+)\s*!!\}/', $trimmed, $xssMatch)) {
                    $findings[] = [
                        'type' => 'Cross-Site Scripting (XSS / Unescaped Output)',
                        'severity' => 'High',
                        'line' => $lineNum,
                        'code_excerpt' => mb_substr($trimmed, 0, 160),
                        'owASP_category' => 'A03:2021-Injection (XSS)',
                        'description' => 'طباعة متغير مباشرة باستخدام {!! !!} دون تعقيم مسبق، مما يتيح حقن وسوم HTML/JavaScript ضارة.',
                        'remediation' => 'استخدم التوجيه المحمي قياسياً {{ $var }} للتشفير التلقائي لـ HTML Entities، أو استخدم دالة e() أو strip_tags() عند الضرورة.',
                    ];
                }
            }

            // 3. فحص CSRF Token في نماذج الـ HTML
            if ($scope === 'all_vulnerabilities' || $scope === 'csrf_and_auth_middleware') {
                if (preg_match('/<form\b[^>]*\bmethod=["\']?(POST|PUT|DELETE|PATCH)["\']?/i', $trimmed)) {
                    // البحث في السطور التالية مباشرة عن @csrf
                    $hasCsrf = false;
                    for ($k = $index; $k < min(count($lines), $index + 6); $k++) {
                        if (str_contains($lines[$k], '@csrf') || str_contains($lines[$k], 'csrf_field()') || str_contains($lines[$k], '_token')) {
                            $hasCsrf = true;
                            break;
                        }
                    }
                    if (!$hasCsrf) {
                        $findings[] = [
                            'type' => 'Missing CSRF Token in Form',
                            'severity' => 'Critical',
                            'line' => $lineNum,
                            'code_excerpt' => mb_substr($trimmed, 0, 160),
                            'owASP_category' => 'A01:2021-Broken Access Control (CSRF)',
                            'description' => 'نموذج إرسال بيانات (POST/PUT/DELETE) يفتقر إلى توجيه الحماية @csrf مما يجعله عرضة لهجمات تزوير الطلبات.',
                            'remediation' => 'أضف توجيه @csrf مباشرة داخل وسم <form>.',
                        ];
                    }
                }
            }

            // 4. فحص Mass Assignment & Validation
            if ($scope === 'all_vulnerabilities' || $scope === 'mass_assignment') {
                if (preg_match('/::(create|update)\s*\(\s*\$request->all\(\)\s*\)/', $trimmed)) {
                    $findings[] = [
                        'type' => 'Mass Assignment Vulnerability',
                        'severity' => 'High',
                        'line' => $lineNum,
                        'code_excerpt' => mb_substr($trimmed, 0, 160),
                        'owASP_category' => 'A04:2021-Insecure Design (Mass Assignment)',
                        'description' => 'تمرير $request->all() مباشرة إلى النموذج يتيح للمهاجمين تعديل حقول حساسة غير مصرح بها (مثل is_admin, role, balance, user_id).',
                        'remediation' => 'استخدم $request->validated() مع كلاس FormRequest، أو حدد الحقول المسموحة فقط عبر $request->only([...]).',
                    ];
                }
            }

            // 5. فحص أمان المسارات المفتوحة للتعديل دون Middleware
            if ($scope === 'all_vulnerabilities' || $scope === 'csrf_and_auth_middleware') {
                if (preg_match('/Route::(post|put|delete|patch)\s*\(/i', $trimmed)) {
                    if (str_contains($trimmed, 'withoutMiddleware') || (str_contains($source, 'routes') && !str_contains($trimmed, 'middleware') && !str_contains($trimmed, 'auth'))) {
                        // تنبيه إذا كان المسار يحتوي على كلمات حساسة مثل delete, update, admin, balance
                        if (preg_match('/(admin|delete|destroy|update|balance|payout|status)/i', $trimmed)) {
                            $findings[] = [
                                'type' => 'Potentially Unprotected Sensitive Mutation Route',
                                'severity' => 'High',
                                'line' => $lineNum,
                                'code_excerpt' => mb_substr($trimmed, 0, 160),
                                'owASP_category' => 'A01:2021-Broken Access Control',
                                'description' => 'مسار تعديل أو حذف عمليات حساسة قد لا يكون مغلفاً بميدلوير المصادقة (Auth/Role Middleware).',
                                'remediation' => 'تأكد من تغليف المسار بميدلوير الحماية الخاص بنطاقه (مثل auth:admin أو auth:seller أو auth:supplier).',
                            ];
                        }
                    }
                }
            }
        }

        return json_encode([
            'status' => 'success',
            'scanned_source' => $source,
            'total_lines_scanned' => count($lines),
            'vulnerabilities_found' => count($findings),
            'scan_scope' => $scope,
            'findings' => $findings,
            'security_summary' => count($findings) === 0 
                ? '✅ الكود سليم أمنياً ومطابق لمعايير الحماية الوقائية لـ Laravel 10.' 
                : '⚠️ تم رصد ثغرات أو ممارسات أمنية غير آمنة تتطلب ترقيعاً فورياً.',
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}

