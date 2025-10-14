<?php

namespace App\Overrides;

use CourierDZ\Contracts\ShippingProviderContract as BeseShippingProviderContract;
use CourierDZ\ProviderIntegrations\YalidineProviderIntegration;

// use CourierDZ\Exceptions\CreateOrderException;
// use CourierDZ\Exceptions\HttpException;
// use GuzzleHttp\Exception\GuzzleException;

class YalidineProvider extends BeseShippingProviderContract
{
    use YalidineProviderIntegration;
    /**
     * Validation rules for creating an order.
     *
     * @var array<non-empty-string, non-empty-string>
     */
    public array $getCreateOrderValidationRules = [
        'order_id' => 'required|string',
        'from_wilaya_name' => 'required|string',
        'firstname' => 'required|string',
        'familyname' => 'required|string',
        'contact_phone' => 'required|string',
        'address' => 'required|string',
        'to_commune_name' => 'required|string',
        'to_wilaya_name' => 'required|string',
        'product_list' => 'required|string',
        'price' => 'required|numeric|min:0|max:150000',
        'do_insurance' => 'required|boolean',
        'declared_value' => 'required|numeric|min:0|max:150000',
        'length' => 'required|numeric|min:0',
        'width' => 'required|numeric|min:0',
        'height' => 'required|numeric|min:0',
        'weight' => 'required|numeric|min:0',
        'freeshipping' => 'required|boolean',
        'is_stopdesk' => 'required|boolean',
        'stopdesk_id' => 'required_if:is_stopdesk,true|string',
        'has_exchange' => 'required|boolean',
        'product_to_collect' => 'sometimes|nullable',
    ];

    public function getCreateOrderValidationRules(): array
    {
        return $this->getCreateOrderValidationRules;
    }

    public function createOrder(array $orderData): array
    {
        $this->validateCreate($orderData);

        try {
            // Initialize Guzzle client
            $client = new Client();

            // Define the headers
            $headers = [
                'X-API-ID' => $this->credentials['id'],
                'X-API-TOKEN' => $this->credentials['token'],
                'Content-Type' => 'application/json',
            ];

            $requestBody = json_encode([$orderData], JSON_UNESCAPED_UNICODE);

            if ($requestBody === false) {
                throw new CreateOrderException('Create Order failed : JSON encoding error');
            }

            $request = new Request('POST', static::apiDomain().'/v1/parcels/', $headers, $requestBody);

            $response = $client->send($request);

            // Get the response body
            $body = $response->getBody()->getContents();

            $arrayResponse = json_decode($body, true);

            $message = $arrayResponse[$orderData['order_id']]['message'];

            // Check if the order creation was successful
            if ($arrayResponse[$orderData['order_id']]['success'] != 'true') {
                throw new CreateOrderException('Create Order failed ( `'.$message.'` ) : '.implode(' ', $arrayResponse[$orderData['order_id']]));
            }

            // Return the created order
            return $arrayResponse[$orderData['order_id']];
        } catch (GuzzleException $guzzleException) {
            // Handle exceptions
            throw new HttpException($guzzleException->getMessage());
        }
    }
}
