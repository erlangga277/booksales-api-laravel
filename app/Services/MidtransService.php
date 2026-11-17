<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class MidtransService
{
    private string $serverKey;
    private bool $isProduction;

    public function __construct()
    {
        $this->serverKey = config('services.midtrans.server_key');
        $this->isProduction = (bool) config('services.midtrans.is_production', false);
    }

    private function getSnapBaseUrl(): string
    {
        return $this->isProduction
            ? 'https://app.midtrans.com/snap/v1'
            : 'https://app.sandbox.midtrans.com/snap/v1';
    }

    public function createSnapToken(array $params): string
    {
        $response = Http::withBasicAuth($this->serverKey, '')
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
            ->post("{$this->getSnapBaseUrl()}/transactions", $params);

        if ($response->failed()) {
            $errorMessage = $response->json('error_messages.0') ?? 'Gagal membuat sesi pembayaran Midtrans.';
            throw new Exception($errorMessage);
        }

        return $response->json('token');
    }
}
