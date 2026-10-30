<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CloudflareService
{
    protected string $accountId;
    protected string $zoneId;
    protected string $apiToken;
    protected string $fallbackOrigin;
    protected string $apiBaseUrl;

    public function __construct()
    {
        $this->accountId = (string) config('cloudflare.account_id', '');
        $this->zoneId = (string) config('cloudflare.zone_id', '');
        $this->apiToken = (string) config('cloudflare.api_token', '');
        $this->fallbackOrigin = (string) config('cloudflare.fallback_origin', 'fallback1.dzora.net');
        $this->apiBaseUrl = rtrim((string) config('cloudflare.api_base_url', 'https://api.cloudflare.com/client/v4'), '/');
    }

    /**
     * Check if Cloudflare API credentials are configured.
     */
    public function isConfigured(): bool
    {
        return !empty($this->zoneId) && !empty($this->apiToken);
    }

    /**
     * Get configured fallback origin.
     */
    public function getFallbackOrigin(): string
    {
        return $this->fallbackOrigin;
    }

    /**
     * Register a new custom hostname in Cloudflare SSL for SaaS.
     *
     * @param string $hostname Domain name (e.g., example.com)
     * @return array
     */
    public function createCustomHostname(string $hostname): array
    {
        $hostname = strtolower(trim($hostname));

        if (!$this->isConfigured()) {
            Log::warning("Cloudflare credentials missing. Mocking custom hostname creation for: {$hostname}");
            return [
                'success' => true,
                'id' => 'mock_' . md5($hostname),
                'status' => 'pending',
                'ssl_status' => 'pending_validation',
                'errors' => ['ملاحظة: مفاتيح Cloudflare API لم تضبط في .env بعد، تم تسجيل النطاق محلياً بحالة انتظار.'],
                'data' => [],
            ];
        }

        $url = "{$this->apiBaseUrl}/zones/{$this->zoneId}/custom_hostnames";

        try {
            $response = Http::withToken($this->apiToken)
                ->timeout(20)
                ->post($url, [
                    'hostname' => $hostname,
                    'ssl' => [
                        'method' => 'http',
                        'type' => 'dv',
                        'settings' => [
                            'min_tls_version' => '1.2',
                        ],
                    ],
                ]);

            $json = $response->json();

            if ($response->successful() && !empty($json['success'])) {
                $result = $json['result'] ?? [];
                return [
                    'success' => true,
                    'id' => $result['id'] ?? null,
                    'status' => $result['status'] ?? 'pending',
                    'ssl_status' => $result['ssl']['status'] ?? 'pending_validation',
                    'errors' => [],
                    'data' => $result,
                ];
            }

            $errors = array_map(function ($err) {
                return $err['message'] ?? 'Unknown Cloudflare error';
            }, $json['errors'] ?? []);

            Log::error("Cloudflare custom hostname create failed for {$hostname}:", $errors);

            return [
                'success' => false,
                'id' => null,
                'status' => 'error',
                'ssl_status' => null,
                'errors' => !empty($errors) ? $errors : ['فشل الاتصال بـ Cloudflare API'],
                'data' => $json,
            ];
        } catch (\Throwable $e) {
            Log::error("Cloudflare API Exception on createCustomHostname: " . $e->getMessage());

            return [
                'success' => false,
                'id' => null,
                'status' => 'error',
                'ssl_status' => null,
                'errors' => [$e->getMessage()],
                'data' => [],
            ];
        }
    }

    /**
     * Retrieve status and details of a custom hostname.
     *
     * @param string $hostnameId Cloudflare custom hostname ID
     * @return array
     */
    public function getCustomHostname(string $hostnameId): array
    {
        if (!$this->isConfigured() || str_starts_with($hostnameId, 'mock_')) {
            return [
                'success' => true,
                'status' => 'pending',
                'ssl_status' => 'pending_validation',
                'errors' => [],
                'data' => [],
            ];
        }

        $url = "{$this->apiBaseUrl}/zones/{$this->zoneId}/custom_hostnames/{$hostnameId}";

        try {
            $response = Http::withToken($this->apiToken)
                ->timeout(15)
                ->get($url);

            $json = $response->json();

            if ($response->successful() && !empty($json['success'])) {
                $result = $json['result'] ?? [];
                return [
                    'success' => true,
                    'status' => $result['status'] ?? 'pending',
                    'ssl_status' => $result['ssl']['status'] ?? null,
                    'errors' => [],
                    'data' => $result,
                ];
            }

            $errors = array_map(function ($err) {
                return $err['message'] ?? 'Unknown Cloudflare error';
            }, $json['errors'] ?? []);

            return [
                'success' => false,
                'status' => 'unknown',
                'ssl_status' => null,
                'errors' => $errors,
                'data' => $json,
            ];
        } catch (\Throwable $e) {
            Log::error("Cloudflare API Exception on getCustomHostname: " . $e->getMessage());
            return [
                'success' => false,
                'status' => 'unknown',
                'ssl_status' => null,
                'errors' => [$e->getMessage()],
                'data' => [],
            ];
        }
    }

    /**
     * Delete a custom hostname from Cloudflare.
     *
     * @param string $hostnameId Cloudflare custom hostname ID
     * @return array
     */
    public function deleteCustomHostname(string $hostnameId): array
    {
        if (!$this->isConfigured() || str_starts_with($hostnameId, 'mock_')) {
            return [
                'success' => true,
                'errors' => [],
            ];
        }

        $url = "{$this->apiBaseUrl}/zones/{$this->zoneId}/custom_hostnames/{$hostnameId}";

        try {
            $response = Http::withToken($this->apiToken)
                ->timeout(15)
                ->delete($url);

            $json = $response->json();

            if ($response->successful() && !empty($json['success'])) {
                return [
                    'success' => true,
                    'errors' => [],
                ];
            }

            $errors = array_map(function ($err) {
                return $err['message'] ?? 'Unknown Cloudflare error';
            }, $json['errors'] ?? []);

            return [
                'success' => false,
                'errors' => $errors,
            ];
        } catch (\Throwable $e) {
            Log::error("Cloudflare API Exception on deleteCustomHostname: " . $e->getMessage());
            return [
                'success' => false,
                'errors' => [$e->getMessage()],
            ];
        }
    }
}
