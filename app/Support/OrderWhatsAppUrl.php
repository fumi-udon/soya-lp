<?php

namespace App\Support;

use App\Models\Order;
use App\Models\Tenant;

class OrderWhatsAppUrl
{
    /**
     * Prefilled WhatsApp message URL (customer must open via explicit tap).
     */
    public static function build(Order $order, Tenant $tenant): string
    {
        $waNumber = $tenant->whatsapp_number ?: '216557786656';
        $storeName = $tenant->name;

        $order->loadMissing('items');

        $text = "*NEW ORDER - {$storeName}*\n";
        $text .= '*Order ID:* #'.$order->order_number."\n";
        $text .= "------------------------\n";
        $text .= '*Guest:* '.$order->customer_name."\n";
        $text .= '*Phone:* '.$order->customer_phone."\n";
        $text .= '*Type:* '.$order->order_type."\n";
        if ($order->notes) {
            $text .= '*Notes:* '.$order->notes."\n";
        }
        $text .= "------------------------\n";

        foreach ($order->items as $item) {
            $text .= '1x '.$item->product_name.' - '.number_format((float) $item->price, 3, '.', '')." DT\n";
            $variants = $item->variants;
            if (is_array($variants) && count($variants) > 0) {
                $extras = collect($variants)->pluck('name')->implode(', ');
                $text .= '   + '.$extras."\n";
            }
        }
        $text .= "------------------------\n";
        $text .= '*Total:* '.number_format((float) $order->total_price, 3, '.', '')." DT\n\n";
        $text .= '_Waiting for shop confirmation..._';

        return 'https://api.whatsapp.com/send/?phone='.$waNumber
            .'&text='.rawurlencode($text)
            .'&type=phone_number&app_absent=0';
    }
}
