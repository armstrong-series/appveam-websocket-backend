<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Actions\ProcessPaymentAction;
use App\Actions\UpdatePaymentStatusAction;
use App\Models\Payment;
use App\Http\Requests\ChangePaymentStatus;
use App\Enums\PaymentStatus;

class PaymentController extends Controller
{

    public function __construct(
        protected ProcessPaymentAction $processPaymentAction,
        protected UpdatePaymentStatusAction $updatePaymentStatusAction
    ) {}



    public function create(PaymentRequest $request)
    {
        $data = $request->validated();

        $data['customer_id'] = auth()->id();

        $payment = $this->processPaymentAction->execute($data);

        return appVeamResponse($payment, 201, 'Payment created.');
    }



    public function updateStatus(ChangePaymentStatus $request, Payment $payment)
    {
        $statusEnum = PaymentStatus::from($request->status);

        $updated = $this->updatePaymentStatusAction->execute($payment, $statusEnum);

        return appVeamResponse($updated, 200, 'Payment status updated.');
    }
}