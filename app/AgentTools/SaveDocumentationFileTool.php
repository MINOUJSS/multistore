<?php

namespace App\AgentTools;

use LarAgent\Core\Contracts\DataModel;
use LarAgent\Tool;
use Illuminate\Support\Facades\File;

class SaveDocumentationFileTool extends Tool
{
    protected string $name = 'save_documentation_file';

    protected string $description = 'حفظ وتخزين ملف توثيق أو دليل مستخدم بصيغة Markdown (.md) في مجلد التوثيق docs/ الخاص بالمشروع لتسهيل وصول الإدارة والمستخدمين إليه.';

    protected array $properties = [
        'file_name' => [
            'type' => 'string',
            'description' => 'اسم ملف التوثيق مع الامتداد .md (مثال: custom-domain-guide.md أو whatsapp-orders-guide.md).',
        ],
        'content' => [
            'type' => 'string',
            'description' => 'محتوى التوثيق الكامل بصيغة Markdown، يشمل العناوين، خطوات الاستخدام، التنبيهات، والأسئلة الشائعة.',
        ],
        'category' => [
            'type' => 'string',
            'description' => 'تصنيف الدليل لتنظيم الملفات داخل مجلد فرعي (مثال: user_guides, features, technical, faq).',
            'enum' => ['user_guides', 'features', 'technical', 'faq'],
        ],
    ];

    protected array $required = ['file_name', 'content'];

    protected array $metaData = [];

    protected function handle(array|DataModel $input): mixed
    {
        $fileName = is_array($input) ? ($input['file_name'] ?? '') : ($input->file_name ?? '');
        $content = is_array($input) ? ($input['content'] ?? '') : ($input->content ?? '');
        $category = is_array($input) ? ($input['category'] ?? 'user_guides') : ($input->category ?? 'user_guides');

        if (empty($fileName) || empty($content)) {
            return [
                'status' => 'error',
                'message' => 'اسم الملف والمحتوى مطلوبان لحفظ التوثيق.',
            ];
        }

        // تنظيف اسم الملف والتأكد من امتداد .md
        $cleanFileName = basename($fileName);
        if (!str_ends_with(strtolower($cleanFileName), '.md')) {
            $cleanFileName .= '.md';
        }

        // تحديد مسار الحفظ داخل مجلد docs
        $targetDirectory = base_path('docs/' . $category);
        $fullPath = $targetDirectory . '/' . $cleanFileName;

        try {
            if (!File::exists($targetDirectory)) {
                File::makeDirectory($targetDirectory, 0755, true, true);
            }

            File::put($fullPath, $content);

            return [
                'status' => 'success',
                'message' => "تم حفظ ملف التوثيق بنجاح.",
                'file_name' => $cleanFileName,
                'category' => $category,
                'relative_path' => 'docs/' . $category . '/' . $cleanFileName,
                'file_size_bytes' => strlen($content),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 'error',
                'message' => 'فشل حفظ ملف التوثيق: ' . $e->getMessage(),
            ];
        }
    }
}

