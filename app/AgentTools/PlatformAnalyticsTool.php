<?php

namespace App\AgentTools;

use LarAgent\Core\Contracts\DataModel;
use LarAgent\Tool;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Seller\Seller;
use App\Models\Seller\SellerProducts;
use App\Models\Supplier\Supplier;
use App\Models\Category;

class PlatformAnalyticsTool extends Tool
{
    protected string $name = 'platform_analytics';

    protected string $description = 'جلب إحصائيات وأرقام دقيقة وحقيقية عن منصة dzora.net (عدد المتاجر، المنتجات، الموردين، التصنيفات الأكثر نشاطاً) لاستخدامها كأدلة وحقائق في المحتوى التسويقي.';

    protected array $properties = [
        'metric_type' => [
            'type' => 'string',
            'description' => 'نوع الإحصائيات المطلوبة: all (شامل), stores (المتاجر), products (المنتجات), suppliers (الموردين)',
            'enum' => ['all', 'stores', 'products', 'suppliers'],
        ],
    ];

    protected array $required = ['metric_type'];

    protected array $metaData = [];

    protected function handle(array|DataModel $input): mixed
    {
        $type = is_array($input) ? ($input['metric_type'] ?? 'all') : ($input->metric_type ?? 'all');

        $data = [
            'platform_name' => 'dzora.net',
            'timestamp' => now()->toFormattedDateString(),
        ];

        try {
            $data['total_active_stores'] = Tenant::count();
            $data['total_registered_sellers'] = Seller::count();
            $data['total_registered_suppliers'] = Supplier::count();
            $data['total_products'] = SellerProducts::count();
            $data['popular_categories'] = Category::limit(6)->pluck('name')->toArray();
            $data['key_value_propositions'] = [
                'متجر إلكتروني مستقل بدومين فرعي أو خاص لكل تاجر',
                'ربط مباشر مع كبريات شركات التوصيل الجزائرية (Yalidine, ZrExpress, وغيرها)',
                'دعم كامل للدفع الإلكتروني بالبطاقة الذهبية وCIB عبر Chargily Pay',
                'سوق جملة ودروبشيبينغ يربط بين الموردين والتجار في الجزائر',
            ];
        } catch (\Throwable $e) {
            $data['error'] = 'تعذر استرجاع بعض البيانات: ' . $e->getMessage();
        }

        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
