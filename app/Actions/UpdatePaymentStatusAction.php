<?php

namespace App\Actions;

use App\Services\PaymentService;
use App\Models\Payment;
use App\Enums\PaymentStatus;

class UpdatePaymentStatusAction
{

    public function __construct(protected PaymentService $paymentService) {}

    public function execute(Payment $payment, PaymentStatus $status)
    {
        return $this->paymentService->updateStatus($payment, $status->value);
    }
}