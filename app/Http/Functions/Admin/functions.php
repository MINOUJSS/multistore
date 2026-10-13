<?php
function get_admin_data_from_id($id)
{
    $admin = App\Models\Admin::find($id);
    if(!$admin) {
        return null;
    }
    return $admin;
}

if (!function_exists('admin_media_service')) {
    /**
     * Get instance of AdminMediaService.
     */
    function admin_media_service(): \App\Services\Admins\Admin\AdminMediaService
    {
        return app(\App\Services\Admins\Admin\AdminMediaService::class);
    }
}

if (!function_exists('admin_file_url')) {
    /**
     * Get public URL for an admin file (supporting both R2 and local storage).
     */
    function admin_file_url(?string $path): string
    {
        if (empty($path)) {
            return '';
        }
        return admin_media_service()->getUrl($path);
    }
}