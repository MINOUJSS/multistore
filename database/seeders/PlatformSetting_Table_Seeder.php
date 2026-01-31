<?php

namespace Database\Seeders;

use App\Models\PlatformSetting;
use Illuminate\Database\Seeder;

class PlatformSetting_Table_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // default site name
        $platform_name = PlatformSetting::create([
            'key' => 'platform_name',
            'value' => config('app.name'),
            'type' => 'string',
            'description' => 'اسم المنصة',
            'status' => 'active',
        ]);
        // default contact email
        $platform_email = PlatformSetting::create([
            'key' => 'platform_email',
            'value' => 'dzora.net@gmailcom',
            'type' => 'string',
            'description' => 'بريد المنصة',
            'status' => 'active',
        ]);
        // default contact phone
        $platform_phone = PlatformSetting::create([
            'key' => 'platform_phone',
            'value' => '123456789',
            'type' => 'string',
            'description' => 'رقم المنصة',
            'status' => 'active',
        ]);
        // default language
        $platform_language = PlatformSetting::create([
            'key' => 'platform_language',
            'value' => 'ar',
            'type' => 'string',
            'description' => 'لغة المنصة',
            'status' => 'active',
        ]);
        // default currency
        $platform_currency = PlatformSetting::create([
            'key' => 'platform_currency',
            'value' => 'DZD',
            'type' => 'string',
            'description' => 'عملة المنصة',
            'status' => 'active',
        ]);
        // default logo
        $platform_logo = PlatformSetting::create([
            'key' => 'platform_logo',
            'value' => 'logo.png',
            'type' => 'string',
            'description' => 'لوجو المنصة',
            'status' => 'active',
        ]);
        // default favicon
        $platform_favicon = PlatformSetting::create([
            'key' => 'platform_favicon',
            'value' => 'favicon.png',
            'type' => 'string',
            'description' => 'ايقونة المنصة',
            'status' => 'active',
        ]);
        // default address
        $platform_address = PlatformSetting::create([
            'key' => 'platform_address',
            'value' => 'address',
            'type' => 'string',
            'description' => 'عنوان المنصة',
            'status' => 'active',
        ]);
        // default copyright
        $platform_copyright = PlatformSetting::create([
            'key' => 'platform_copyright',
            'value' => 'copyright',
            'type' => 'string',
            'description' => 'حقوق المنصة',
            'status' => 'active',
        ]);
        // default facebook
        $platform_facebook = PlatformSetting::create([
            'key' => 'platform_facebook',
            'value' => 'facebook.com',
            'type' => 'string',
            'description' => 'صفحة فيسبوك المنصة',
            'status' => 'active',
        ]);
        // default twitter
        $platform_twitter = PlatformSetting::create([
            'key' => 'platform_twitter',
            'value' => 'twitter.com',
            'type' => 'string',
            'description' => 'صفحة تويتر المنصة',
            'status' => 'active',
        ]);
        // default instagram
        $platform_instagram = PlatformSetting::create([
            'key' => 'platform_instagram',
            'value' => 'instagram.com',
            'type' => 'string',
            'description' => 'صفحة انستغرام المنصة',
            'status' => 'active',
        ]);
        // default tiktok
        $platform_tiktok = PlatformSetting::create([
            'key' => 'platform_tiktok',
            'value' => 'tiktok.com',
            'type' => 'string',
            'description' => 'صفحة تيك توك المنصة',
            'status' => 'active',
        ]);
        // default youtube
        $platform_youtube = PlatformSetting::create([
            'key' => 'platform_youtube',
            'value' => 'youtube.com',
            'type' => 'string',
            'description' => 'صفحة يوتيوب المنصة',
            'status' => 'active',
        ]);
        // default google_analitics
        $analitics_code = '
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-NMWMGYJ1TR"></script>';

        $analitics_code .= "<script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', 'G-NMWMGYJ1TR');
        </script>";
        $platform_google_analitics = PlatformSetting::create([
            'key' => 'google_analitics',
            'value' => $analitics_code,
            'type' => 'string',
            'description' => 'كود جوجل المنصة',
            'status' => 'active',
        ]);
        // default facebook_pixel
        $platform_facebook_pixel = PlatformSetting::create([
            'key' => 'facebook_pixel',
            'value' => 'facebook_pixel',
            'type' => 'string',
            'description' => 'كود فيسبوك المنصة',
            'status' => 'active',
        ]);
    }
}
