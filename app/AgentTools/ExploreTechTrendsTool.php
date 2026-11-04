<?php

namespace App\AgentTools;

use LarAgent\Core\Contracts\DataModel;
use LarAgent\Tool;
use Illuminate\Support\Facades\Http;

class ExploreTechTrendsTool extends Tool
{
    protected string $name = 'explore_tech_trends';

    protected string $description = 'أداة التعلم الذاتي واستكشاف التحديثات التقنية: فحص أحدث إصدارات الحزم والمستودعات عبر GitHub والويب (مثل Laravel, Tenancy, Livewire, Tailwind CSS, Alpine.js, Chargily, Courierdz) لاستخلاص ابتكارات تفيد منصة dzora.net.';

    protected array $properties = [
        'technology_or_package' => [
            'type' => 'string',
            'description' => 'اسم الحزمة أو التقنية المراد استكشافها (مثال: stancl/tenancy, laravel/framework, livewire/livewire, tailwindcss, alpinejs, chargily/chargily-pay).',
        ],
        'scouting_type' => [
            'type' => 'string',
            'description' => 'نوع الاستكشاف: github_repo_release (فحص أحدث إصدار لمستودع GitHub), web_technology_trends (أحدث تريندات التقنية عبر الويب), laravel_ecosystem (أفضل الممارسات لمنظومة لارافيل), frontend_ui_trends (تريندات الواجهات وتجربة المستخدم الحديثة)',
            'enum' => ['github_repo_release', 'web_technology_trends', 'laravel_ecosystem', 'frontend_ui_trends'],
        ],
    ];

    protected array $required = ['technology_or_package'];

    protected array $metaData = [];

    protected function handle(array|DataModel $input): mixed
    {
        $target = is_array($input) ? ($input['technology_or_package'] ?? '') : ($input->technology_or_package ?? '');
        $type = is_array($input) ? ($input['scouting_type'] ?? 'github_repo_release') : ($input->scouting_type ?? 'github_repo_release');

        $githubData = null;
        if (str_contains($target, '/') || $type === 'github_repo_release') {
            $githubData = $this->fetchGitHubRelease($target);
        }

        $webData = $this->fetchWebTechTrends($target);
        $curatedInsights = $this->getCuratedEcosystemInsights($target, $type);

        return json_encode([
            'status' => 'success',
            'target_technology' => $target,
            'scouting_type' => $type,
            'github_release_data' => $githubData,
            'web_trends_data' => $webData,
            'curated_ecosystem_insights' => $curatedInsights,
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    protected function fetchGitHubRelease(string $package): ?array
    {
        // تنظيف اسم المستودع (مثال: stancl/tenancy)
        $repo = trim($package);
        if (!str_contains($repo, '/')) {
            $commonRepos = [
                'tenancy' => 'stancl/tenancy',
                'laravel' => 'laravel/framework',
                'livewire' => 'livewire/livewire',
                'alpine' => 'alpinejs/alpine',
                'tailwind' => 'tailwindlabs/tailwindcss',
                'chargily' => 'Chargily/chargily-pay-php',
            ];
            $repo = $commonRepos[strtolower($repo)] ?? null;
        }

        if (!$repo) {
            return null;
        }

        try {
            $response = Http::timeout(5)
                ->withHeaders([
                    'User-Agent' => 'dzora-ai-scout/1.0',
                    'Accept' => 'application/vnd.github.v3+json',
                ])
                ->get("https://api.github.com/repos/{$repo}/releases/latest");

            if ($response->successful()) {
                $data = $response->json();
                $body = $data['body'] ?? '';
                if (mb_strlen($body) > 400) {
                    $body = mb_substr($body, 0, 400) . '...';
                }

                return [
                    'repo' => $repo,
                    'latest_tag' => $data['tag_name'] ?? 'N/A',
                    'name' => $data['name'] ?? '',
                    'published_at' => $data['published_at'] ?? '',
                    'summary' => $body,
                ];
            }
        } catch (\Throwable $e) {
            // استمرار بهدوء
        }

        return null;
    }

    protected function fetchWebTechTrends(string $query): ?array
    {
        $serperKey = env('SERPER_API_KEY');
        $tavilyKey = env('TAVILY_API_KEY');

        if (!empty($serperKey)) {
            try {
                $response = Http::timeout(6)->withHeaders([
                    'X-API-KEY' => $serperKey,
                    'Content-Type' => 'application/json',
                ])->post('https://google.serper.dev/search', [
                    'q' => $query . ' latest features tutorial best practices 2026',
                    'num' => 3,
                ]);

                if ($response->successful() && !empty($response->json('organic'))) {
                    return array_map(function ($item) {
                        return [
                            'title' => $item['title'] ?? '',
                            'snippet' => $item['snippet'] ?? '',
                        ];
                    }, $response->json('organic'));
                }
            } catch (\Throwable $e) {
                // تجاوز الفشل
            }
        }

        return null;
    }

    protected function getCuratedEcosystemInsights(string $target, string $type): array
    {
        return [
            'platform_relevance' => 'dzora.net Multi-Store E-Commerce Platform',
            'recommended_architectural_patterns' => [
                'Multi-Tenancy' => 'عزل قواعد بيانات المتاجر المستأجرة عبر stancl/tenancy مع توحيد مسارات تسجيل الدخول المركزية.',
                'Performance & Caching' => 'تفعيل التخزين المؤقت لاستعلامات المتاجر، واستخدام Redis/Database queues لمعالجة مهام الشحن والـ Webhooks في الخلفية.',
                'Modern UI Components' => 'بناء مكونات Blade متجاوبة مدعومة بـ Tailwind CSS وتفاعلات Alpine.js خفيفة الوزن لتسريع تحميل صفحات المتاجر.',
            ],
            'key_focus_areas' => [
                'سرعة تحميل المتاجر على شبكات الهاتف النقال الجزائرية (3G/4G).',
                'سلاسة واجهة إتمام الشراء بنقرة واحدة (One-page checkout).',
                'الموثوقية العالية في معالجة إشعارات Webhooks لـ Chargily Pay وشركات التوصيل.',
            ],
        ];
    }
}

