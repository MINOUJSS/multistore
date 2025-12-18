<?php
function get_admin_data_from_id($id)
{
    $admin = App\Models\Admin::find($id);
    if(!$admin) {
        return null;
    }
    return $admin;
}