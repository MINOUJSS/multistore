<?php

namespace App\Livewire;

use App\Models\Tenant;
use Livewire\Component;

class SupplierStoreValidator extends Component
{
    public $tenant_name='';
    public $statu = 'invalid';
    public $message = 'إختر اسم مميز لمتجرك الإلكتروني';
    //check if tenant is already registered
    function isRegistered()
    {
        $id=$this->tenant_name.'.supplier';
        $tenant=Tenant::where('id',$id)->first();   
        if($tenant==null && $this->tenant_name!=="")
            {
               $this->statu = 'valid';
               $this->message = $this->tenant_name.'.'.request()->host();
            }else
            {
                $this->statu = 'invalid';
                $this->message = 'هذا الاسم غير متاح';
            }       
    }
    public function render()
    {
        return view('livewire.supplier-store-validator');
    }
}
