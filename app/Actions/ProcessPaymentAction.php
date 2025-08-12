<?php

namespace App\Actions;

use App\Services\PaymentService;

class ProcessPaymentAction
{

    public function __construct(protected PaymentService $paymentService) {}

    public function execute(array $payload)
    {
        return $this->paymentService->create($payload);
    }
}