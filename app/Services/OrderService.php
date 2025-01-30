<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class OrderService
{
    public function createOrder(array $data)
    {
        $order = Order::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'address' => $data['address'],
        ]);

        foreach ($data['basket'] as $item) {
            $order->basketItems()->create($item);

            if ($item['type'] === 'subscription') {
                $this->sendSubscriptionToThirdParty($item);
            }
        }

        return $order;
    }

    private function sendSubscriptionToThirdParty($item)
    {
        try {
            $response = Http::post('https://very-slow-api.com/orders', [
                'ProductName' => $item['name'],
                'Price' => $item['price'],
                'Timestamp' => now()->toIso8601String(),
            ]);

            if ($response->successful()) {
                Log::info('Successfully sent subscription to third party for ' . $item['name']);
            } else {
                Log::error('Failed to send subscription to third party for ' . $item['name'] .
                    ': ' . $response->status() . ' - ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Failed to send subscription to third party: ' . $e->getMessage());
        }
    }
}
