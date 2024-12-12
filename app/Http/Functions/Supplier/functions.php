<?php
//function to chicke if supplier folder exists
function supplier_exists($store_name)
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
//get supplier store name
function get_supplier_store_name($tenant_id)
{
    $store_name=explode('.',$tenant_id);
    return $store_name[0];
}
//get supplier status
function get_supplier_status($tenant_id)
{
    $supplier=App\Models\Supplier::where('tenant_id',$tenant_id)->first();
    return $supplier->status;
}
//get supplier data
function get_supplier_data($tenant_id)
{
    $supplier=App\Models\Supplier::where('tenant_id',$tenant_id)->first();
    return $supplier;
}
//get supplier plan data
function get_supplier_plan_data($plan_id)
{
    $plan=App\Models\SupplierPlan::where('id',$plan_id)->first();
    return $plan;
}
