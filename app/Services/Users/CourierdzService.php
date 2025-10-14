<?php

namespace App\Services\Users;

use App\Models\ShippingCompaines;
use App\Models\Supplier\SupplierOrders;
use CourierDZ\CourierDZ;
use CourierDZ\Enum\ShippingProvider;
use CourierDZ\Exceptions\HttpException;
use GuzzleHttp\Client;

class CourierdzService
{
    public $order_id;
    public $user_type;
    public $provider_name;

    public function __construct($order_id, $user_type, $provider_name)
    {
        $this->order_id = $order_id;
        $this->user_type = $user_type;
        $this->provider_name = $provider_name;
    }

    // // test connection
    // public function testConnection($key = null, $token = null)
    // {
    //     if ($this->provider_name === 'YALIDINE') {
    //         $shipping_provider = CourierDZ::provider(ShippingProvider::YALIDINE, $this->credentials());
    //     }
    //     // Yalidine providers
    //     $credentials = ['token' => $token, 'id' => $key];

    //     return $this->shipping_provider()->$credentials;
    // }

    public function credentials()
    {
        $shipping_company = ShippingCompaines::where('user_id', auth()->user()->id)->where('status', 'active')->where('name', $this->provider_name)->first();
        $data = json_decode($shipping_company->data);
        // Ecotrack providers
        // $credentials = ['token' => '****'];

        // Procolis providers ( ZREXPRESS )
        // $credentials = ['id' => '****', 'token' => '****'];
        if ($this->provider_name === 'YALIDINE') {
            // Yalidine providers
            $credentials = ['token' => $data->api_token, 'id' => $data->api_id];
        } elseif ($this->provider_name === 'DHD') {
            $credentials = ['token' => $data->token];
        } elseif ($this->provider_name === 'MAYSTRO_DELIVERY') {
            $credentials = ['token' => $data->key];
        }

        // Mayestro Delivery providers
        // $credentials = ['token' => '****'];

        return $credentials;
    }

    // test ShippingProvider

    public function shipping_provider()
    {
        // get shipping provider
        if ($this->provider_name === 'YALIDINE') {
            $shipping_provider = CourierDZ::provider(ShippingProvider::YALIDINE, $this->credentials());
        } elseif ($this->provider_name === 'DHD') {
            $shipping_provider = CourierDZ::provider(ShippingProvider::DHD, $this->credentials());
        } elseif ($this->provider_name === 'MAYSTRO_DELIVERY') {
            $shipping_provider = CourierDZ::provider(ShippingProvider::MAYSTRO_DELIVERY, $this->credentials());
        }
        // $shipping_provider = CourierDZ::provider(ShippingProvider::YALIDINE, $this->credentials());

        // $shipping_provider = new YALIDINE($this->credentials()); // where Xyz is the provider name
        return $shipping_provider;
    }

    public function testCredentials()
    {
        return $this->shipping_provider()->testCredentials();
    }

    public function providersList()
    {
        $providersMetaData = CourierDZ::providers();

        return $providersMetaData;
    }

    // Get Shipping Provider Metadata
    public function providerMetaData()
    {
        return $this->shipping_provider()->metadata();
    }

    // Get Create Parcel ( Order ) Validation Rules
    public function createParcelValidationRules()
    {
        return $this->shipping_provider()->getCreateOrderValidationRules();
    }

    // Get Parcel ( Order ) Details
    public function getParcelDetails($trucking_id)
    {
        return $this->shipping_provider()->getOrder($trucking_id);
    }

    // Retrieving a label ( order )
    public function getLabel($trucking_id)
    {
        return $this->shipping_provider()->orderLabel($trucking_id);
    }

    // Create Order
    public function createOrder()
    {
        try {
            // 1) جلب الطلب حسب نوع المستخدم
            switch ($this->user_type) {
                case 'supplier':
                    $order = SupplierOrders::findOrFail($this->order_id);
                    break;
                case 'seller':
                    // $order = Orders::findOrFail($this->order_id);
                    break;
                default:
                    throw new \Exception('نوع المستخدم غير مدعوم');
            }

            // 2) تجهيز قائمة المنتجات
            $products = '';
            foreach ($order->items as $item) {
                $products .= get_supplier_product_data($item->product_id)->name.'('.$item->quantity.")\n";
            }
            $items = $products; // خليه Array بدل JSON

            // 3) تقسيم الاسم (نتأكد من وجود اسم عائلة)
            $names = explode(' ', trim($order->customer_name));
            $first_name = $names[0] ?? 'Client';
            $family_name = implode(' ', array_slice($names, 1)) ?: $first_name;

            // 4) الشحن مجاني؟
            $free_shipping = $order->free_shipping === 'yes' ? 1 : 0;

            // delivery type
            if ($order->shipping_type == 'to_home') {
                $is_stopdesk = false;
            } else {
                $is_stopdesk = true;
            }

            // 5) إرسال الطلب لمزود الشحن
            if ($this->provider_name === 'YALIDINE') {
                // get yalidin communes
                $communes = $this->get_yalidine_commune_data($order->wilaya_id)['data'];
                // get commune name
                foreach ($communes as $commune) {
                    if ($commune['name'] == get_baladia_data($order->baladia_id)->en_name) {
                        $wilaya_name = $commune['wilaya_name'];
                        $commune_name = $commune['name'];
                        $stopdesk_id = $commune['id'];
                        break;
                    } else {
                        $wilaya_name = $communes[0]['wilaya_name'];
                        $commune_name = $communes[0]['name'];
                        $stopdesk_id = $communes[0]['id'];
                        break;
                    }
                }

                // return response()->json($stopdesk_id);

                $result = $this->shipping_provider()->createOrder([
                    'order_id' => $order->order_number,
                    'from_wilaya_name' => 'Béchar',
                    'firstname' => $first_name,
                    'familyname' => $family_name,
                    'contact_phone' => $order->phone,
                    'address' => $order->shipping_address,
                    'to_commune_name' => $commune_name, // TODO: اربطها بالداتا الحقيقية
                    'to_wilaya_name' => $wilaya_name,
                    'product_list' => $items,
                    'price' => $order->total_price,
                    'do_insurance' => false,
                    'declared_value' => $order->total_price,
                    'height' => 10,
                    'width' => 20,
                    'length' => 30,
                    'weight' => 6,
                    'freeshipping' => $free_shipping,
                    'is_stopdesk' => $is_stopdesk,
                    'stopdesk_id' => $stopdesk_id.'01',
                    'has_exchange' => 0,
                    'product_to_collect' => null,
                ]);
            } elseif ($this->provider_name === 'DHD') {
                $commune = get_wilaya_data($order->wilaya_id)->en_name === 'Alger'
                    ? get_wilaya_data($order->wilaya_id)->en_name.' Centre'
                    : get_wilaya_data($order->wilaya_id)->en_name;

                $result = $this->shipping_provider()->createOrder([
                    'reference' => $order->order_number,
                    'nom_client' => $order->customer_name,
                    'telephone' => $order->phone,
                    'adresse' => $order->shipping_address,
                    'commune' => $commune,
                    'code_wilaya' => $order->wilaya_id,
                    'montant' => $order->total_price,
                    'quantite' => 1,
                    'type' => 1,
                ]);
            } elseif ($this->provider_name === 'MAYSTRO_DELIVERY') {
                $result = $this->shipping_provider()->createOrder([
                    'wilaya' => $order->wilaya_id, // 'required|integer|min:1|max:58',
                    'commune' => 1, 'required|integer|min:1',
                    'destination_text' => $order->shipping_address, 'nullable|string|max:255',
                    'customer_phone' => $order->phone, 'required|numeric|digits_between:9,10',
                    'customer_name' => $order->customer_name, 'required|string|max:255',
                    'product_price' => $order->total_price, 'required|integer',
                    'delivery_type' => 1, 'required|integer|in:0,1', // 0 = Livraison à domicile , 1 = Point de retrait
                    'express' => false, 'boolean',
                    'note_to_driver' => null, 'nullable|string|max:255',
                    'products' => ['product1', 'product2'], 'required|array',
                    'source' => 4, 'required|equals:4',
                    'external_order_id' => $order->order_number, 'nullable|string|max:255',
                ]);
            } else {
                throw new \Exception('مزود الشحن غير معروف');
            }

            // 6) تخزين بيانات التتبع
            $order->shipping_company = $this->provider_name;
            $order->shipping_tracking_number = $result['tracking'] ?? null;
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'تم إنشاء الطلب بنجاح',
                'data' => $result,
            ]);
        } catch (HttpException $e) {
            // معالجة خطأ API
            $message = $e->getMessage();
            $cleanMsg = $message;

            if (preg_match('/({\"error\":.*})/s', $message, $match)) {
                $inner = json_decode($match[1], true);
                if (isset($inner['error']['message'])) {
                    $cleanMsg = $inner['error']['message']
                              .' ('.$inner['error']['description'].')';
                }
            }

            return response()->json([
                'success' => false,
                'message' => $cleanMsg,
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ غير متوقع: '.$e->getMessage(),
            ], 500);
        }
    }

    // delete order
    public function delete_yalidine_order($tracking_id)
    {
        try {
            // Initialize Guzzle client
            $client = new Client(['http_errors' => false]);
            $credentials = $this->credentials();
            // Define the headers
            $headers = [
                'X-API-ID' => $credentials['id'],
                'X-API-TOKEN' => $credentials['token'],
            ];
            // get yalidin communes
            $response = $client->request('DELETE', 'https://api.yalidine.app/v1/parcels/'.$tracking_id, [
                'headers' => $headers,
            ]);

            // Return the response body as an array
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $guzzleException) {
            // Handle exceptions
            throw new HttpException($guzzleException->getMessage());
        }
    }

    public function get_yalidine_commune_data($wilaya_id)
    {
        try {
            // Initialize Guzzle client
            $client = new Client(['http_errors' => false]);
            $credentials = $this->credentials();
            // Define the headers
            $headers = [
                'X-API-ID' => $credentials['id'],
                'X-API-TOKEN' => $credentials['token'],
            ];
            // get yalidin communes
            $response = $client->request('GET', 'https://api.yalidine.app/v1/communes/?has_stop_desk=true&wilaya_id='.$wilaya_id, [
                'headers' => $headers,
            ]);

            // Return the response body as an array
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $guzzleException) {
            // Handle exceptions
            throw new HttpException($guzzleException->getMessage());
        }
    }

    // test yalidin api
    public function test_yalidine($tracking_id)
    {
        try {
            // Initialize Guzzle client
            $client = new Client(['http_errors' => false]);
            $credentials = $this->credentials();
            // Define the headers
            $headers = [
                'X-API-ID' => $credentials['id'],
                'X-API-TOKEN' => $credentials['token'],
            ];
            // get yalidin communes
            $response = $client->request('DELETE', 'https://api.yalidine.app/v1/parcels/'.$tracking_id, [
                'headers' => $headers,
            ]);

            // Return the response body as an array
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $guzzleException) {
            // Handle exceptions
            throw new HttpException($guzzleException->getMessage());
        }
    }

    // ::::::::: DHD ::::::::::
    // delete dhd order
    public function delete_dhd_order($tracking_id)
    {
        try {
            // Initialize Guzzle client
            $client = new Client(['http_errors' => false]);

            $credentials = $this->credentials();

            // return response()->json($this->credentials);

            // Define the headers
            $headers = [
                'Authorization' => 'Bearer '.$credentials['token'],
            ];

            // Make the GET request
            $response = $client->request('DELETE', 'https://platform.dhd-dz.com/api/v1/delete/order?tracking='.$tracking_id.'', [
                'headers' => $headers,
                'Content-Type' => 'application/json',
            ]);

            // Get the response body
            $body = $response->getBody()->getContents();

            // Decode the response body
            $arrayResponse = json_decode($body, true);

            // return response()->json($arrayResponse);

            // Check if the order creation was successful
            if ($arrayResponse['delete'] !== 'success') {
                throw new CreateOrderException('Delete Order failed: '.$arrayResponse['message']);
            }

            // Return the order response
            return $arrayResponse;
        } catch (GuzzleException $guzzleException) {
            // Handle exceptions
            throw new HttpException($guzzleException->getMessage());
        }
    }
}
