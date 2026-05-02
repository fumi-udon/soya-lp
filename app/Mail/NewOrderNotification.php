<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class NewOrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    /** @var Collection<int, array{line: string, kitchen: string|null, price: string, extras: string}> */
    public Collection $lines;

    public function __construct(
        public Order $order,
        public Tenant $tenant
    ) {
        $this->order->loadMissing('items');
        $this->lines = $this->buildLines();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '['.$this->tenant->name.'] New order #'.$this->order->order_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.new-order',
        );
    }

    /**
     * @return Collection<int, array{line: string, kitchen: string|null, price: string, extras: string}>
     */
    protected function buildLines(): Collection
    {
        $productIds = $this->order->items->pluck('product_id')->filter()->unique()->values();
        $staffById = $productIds->isEmpty()
            ? collect()
            : Product::query()->whereIn('id', $productIds)->pluck('staff_name', 'id');

        return $this->order->items->map(function (OrderItem $item) use ($staffById) {
            $kitchen = $staffById->get($item->product_id);
            $kitchen = $kitchen !== null && trim((string) $kitchen) !== '' ? trim((string) $kitchen) : null;

            $extras = '';
            if (is_array($item->variants) && count($item->variants) > 0) {
                $extras = collect($item->variants)->pluck('name')->implode(', ');
            }

            return [
                'line' => $item->product_name,
                'kitchen' => $kitchen,
                'price' => number_format((float) $item->price, 3, '.', '').' DT',
                'extras' => $extras,
            ];
        });
    }
}
