<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Payment;

class PaymentStatusChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public function __construct(public Payment $payment) {}



    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('customer.' . $this->payment->customer_id);
    }


    public function broadcastAs(): string
    {
        return 'payment.status.changed';
    }


    public function broadcastWith(): array
    {
        return [
            'payment_id' => $this->payment->id,
            'status'     => $this->payment->status,
            'amount'     => $this->payment->amount,
            'currency'   => $this->payment->currency
        ];
    }
}
