<?php
//function to chicke if supplier folder exists
function supplier_folder_exists($store_name)
{
    //find the store
    $store=App\Models\Tenant::find($store_name.'.supplier');
    if($store==null)
    {
        return true;
    }
    else
    {
        return false;
    }

}