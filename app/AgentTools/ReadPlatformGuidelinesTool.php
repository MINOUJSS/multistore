<?php

namespace App\AgentTools;

use LarAgent\Core\Contracts\DataModel;
use LarAgent\Tool;
use Illuminate\Support\Facades\File;

class ReadPlatformGuidelinesTool extends Tool
{
    protected string $name = 'read_platform_guidelines';

    protected string $description = 'قراءة وفحص قواعد البرمجة المعمارية لمنصة dzora.net (من ملفات GEMINI.md أو .agents/AGENTS.md) أو استعراض وتفحص مهارة تقنية محددة من مجلد المهارات .agents/skills (مثل: multi-tenant-manager, courierdz-shipping, chargily-payment, multi-store-module-router).';

    protected array $properties = [
        'document_type' => [
            'type' => 'string',
            'description' => 'نوع الوثيقة المطلوبة: rules (القواعد العامة للمشروع), skill (مهارة تقنية متخصصة), list_skills (قائمة بجميع المهارات المتاحة)',
            'enum' => ['rules', 'skill', 'list_skills'],
        ],
        'skill_name' => [
            'type' => 'string',
            'description' => 'اسم المهارة عند اختيار skill (مثال: multi-tenant-manager, courierdz-shipping, chargily-payment, multi-store-module-router, safe-ui-styling)',
        ],
    ];

    protected array $required = ['document_type'];

    protected array $metaData = [];

    protected function handle(array|DataModel $input): mixed
    {
        $docType = is_array($input) ? ($input['document_type'] ?? 'rules') : ($input->document_type ?? 'rules');
        $skillName = is_array($input) ? ($input['skill_name'] ?? '') : ($input->skill_name ?? '');

        try {
            if ($docType === 'list_skills') {
                $skillsDir = base_path('.agents/skills');
                if (!File::exists($skillsDir)) {
                    return json_encode(['status' => 'error', 'message' => 'مجلد المهارات غير موجود.'], JSON_UNESCAPED_UNICODE);
                }

                $directories = File::directories($skillsDir);
                $skillsList = array_map(function ($dir) {
                    $slug = basename($dir);
                    $skillMd = $dir . '/SKILL.md';
                    $description = 'بدون وصف';
                    if (File::exists($skillMd)) {
                        $lines = file($skillMd);
                        foreach ($lines as $line) {
                            if (str_starts_with(trim($line), 'description:')) {
                                $description = trim(str_replace('description:', '', $line));
                                break;
                            }
                        }
                    }
                    return [
                        'skill' => $slug,
                        'description' => $description,
                    ];
                }, $directories);

                return json_encode([
                    'status' => 'success',
                    'available_skills' => $skillsList,
                ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            }

            if ($docType === 'rules') {
                $geminiPath = base_path('GEMINI.md');
                $agentsPath = base_path('.agents/AGENTS.md');

                $content = '';
                if (File::exists($geminiPath)) {
                    $content .= "=== GEMINI.MD (المعايير المعمارية الأساسية) ===\n" . File::get($geminiPath) . "\n\n";
                }
                if (File::exists($agentsPath)) {
                    $content .= "=== AGENTS.MD (قواعد مساحة العمل) ===\n" . File::get($agentsPath);
                }

                if (empty($content)) {
                    return json_encode(['status' => 'error', 'message' => 'ملفات القواعد غير متوفرة حالياً في المسار الافتراضي.'], JSON_UNESCAPED_UNICODE);
                }

                return json_encode([
                    'status' => 'success',
                    'document' => 'Platform Architectural Rules',
                    'content' => mb_substr($content, 0, 15000), // حماية حجم الذاكرة
                ], JSON_UNESCAPED_UNICODE);
            }

            if ($docType === 'skill') {
                if (empty($skillName)) {
                    return json_encode(['status' => 'error', 'message' => 'يرجى تحديد skill_name للاطلاع على تفاصيلها.'], JSON_UNESCAPED_UNICODE);
                }

                $cleanName = basename($skillName);
                $skillPath = base_path(".agents/skills/{$cleanName}/SKILL.md");

                if (!File::exists($skillPath)) {
                    return json_encode([
                        'status' => 'error',
                        'message' => "المهارة [{$cleanName}] غير موجودة في مجلد .agents/skills/.",
                    ], JSON_UNESCAPED_UNICODE);
                }

                return json_encode([
                    'status' => 'success',
                    'skill' => $cleanName,
                    'content' => File::get($skillPath),
                ], JSON_UNESCAPED_UNICODE);
            }

            return json_encode(['status' => 'error', 'message' => 'نوع الوثيقة غير صالح.'], JSON_UNESCAPED_UNICODE);

        } catch (\Throwable $e) {
            return json_encode([
                'status' => 'error',
                'message' => 'تعذر قراءة الوثائق: ' . $e->getMessage(),
            ], JSON_UNESCAPED_UNICODE);
        }
    }
}

