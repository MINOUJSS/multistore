<?php
//get user date_add
function get_user_data($tenant_id)
{
    $user=App\Models\User::where('tenant_id',$tenant_id)->first();
    return $user;
}