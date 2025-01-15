<?php
//get tenant data
function get_tenant_data($tenant_id)
{
    $tenant=App\Models\Tenant::find($tenant_id);
    return $tenant;
}
//tenant to slug
function tenant_to_slug($tenant_id)
{
    $tenant=explode('.',$tenant_id);
    if(count($tenant)>1){
        return $tenant[0].'-'.$tenant[1];
    }else{
        return $tenant[0];
    }
}
//get user date_add
function get_user_data($tenant_id)
{
    $user=App\Models\User::where('tenant_id',$tenant_id)->first();
    return $user;
}
//get user store settings by key
function get_user_store_settings($tenant_id,$key)
{
    $user=App\Models\User::where('tenant_id',$tenant_id)->first();
    $setting=App\Models\UserStoreSetting::where('user_id',$user->id)->where('key',$key)->first();
    return $setting;
}