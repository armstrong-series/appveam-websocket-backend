<?php

namespace App\Services;

use App\Models\Payment;
use App\Events\PaymentStatusChanged;

class PaymentService
{

    public function create(array $data): Payment
    {
        return Payment::create($data);
    }



    public function updateStatus(Payment $payment, string $status): Payment
    {
        $payment->update(['status' => $status]);
        broadcast(new PaymentStatusChanged($payment))->toOthers();
        return $payment;
    }
}