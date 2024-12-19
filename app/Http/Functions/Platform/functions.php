<?php
//get platform data by key
function get_platform_data($key)
{
    return App\Models\PlatformSetting::where('key', $key)->first();
}