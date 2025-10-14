<?php

namespace App\Services\Users\Suppliers;

use Illuminate\Support\Facades\Http;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Stancl\Tenancy\Tenancy;

class GoogleSheetService
{

    public function __construct()
    {
        // $this->tenancy = $tenancy;
        //$this->apiUrl = 'https://script.google.com/macros/s/AKfycbzAg3XKpMab-ZUNkAIBIwd7R6idc2dMo4ZRLGKdxigx3dt_SBezqjUh_0YAY5_2rUyhdg/exec';
    }

    //  protected function getTenantId()
    // {
    //     return $this->tenancy->tenant?->id ?? tenant('id');
    // }

    public function addOrder(array $orderData)
    {
        $user=get_user_data(tenant('id'));
        dd($user);
        $sheet=\App\Models\UserApps::where('user_id',$user->id)->where('app_name','google_sheets')->first();
        // dd(json_decode($sheet->data)->sheet_id);
        $apiUrl=json_decode($sheet->data)->sheet_id;
        $response = Http::post($apiUrl, [
            // 'token' => $this->token,
            'action' => 'addOrder',
            'order' => $orderData
        ]);

        return $response->json();
    }

    // public function getOrders(array $filters = [])
    // {
    //     $response = Http::post($this->apiUrl, [
    //         'token' => $this->token,
    //         'action' => 'getOrders',
    //         'filters' => $filters
    //     ]);

    //     return $response->json();
    // }
}