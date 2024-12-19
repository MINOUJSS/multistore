<?php
//get tenant data
function get_tenant_data($tenant_id)
{
    $tenant=App\Models\Tenant::find($tenant_id);
    return $tenant;
}
//get user date_add
function get_user_data($tenant_id)
{
    $user=App\Models\User::where('tenant_id',$tenant_id)->first();
    return $user;
}