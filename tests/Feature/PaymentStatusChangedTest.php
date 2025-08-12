<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Events\PaymentStatusChanged;
use App\Models\Payment;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class PaymentStatusChangedTest extends TestCase
{
    use RefreshDatabase;

    protected Role $customerRole;
    protected Role $adminRole;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customerRole = Role::factory()->create(['name' => 'customer']);
        $this->adminRole    = Role::factory()->create(['name' => 'admin']);
    }

    public function testChangePaymentStatusOnEventBroadcast()
    {
        Event::fake([PaymentStatusChanged::class]);

        $customer = User::factory()->create([
            'role_id' => $this->customerRole->id,
        ]);

        $payment = Payment::factory()->create([
            'customer_id' => $customer->id,
            'status'      => 'pending',
            'amount'      => 1000,
            'currency'    => 'USD',
        ]);

        event(new PaymentStatusChanged($payment));

        Event::assertDispatched(PaymentStatusChanged::class, function ($event) use ($payment) {
            $this->assertEquals($payment->id, $event->payment->id);
            $this->assertEquals("private-customer.{$payment->customer_id}", $event->broadcastOn()->name);
            $this->assertEquals('payment.status.changed', $event->broadcastAs());
            return true;
        });
    }

    public function testCustomerCanAccessOwnChannel()
    {
        $customer = User::factory()->create([
            'role_id' => $this->customerRole->id,
        ]);

        $this->actingAs($customer, 'api')
            ->post('/broadcasting/auth', [
                'channel_name' => 'private-customer.' . $customer->id,
                'socket_id'    => '1234.5678',
            ])
            ->assertStatus(200);
    }

    public function testCustomerCannotAccessOtherChannel()
    {
        $customer = User::factory()->create([
            'role_id' => $this->customerRole->id,
        ]);
        $otherCustomer = User::factory()->create([
            'role_id' => $this->customerRole->id,
        ]);

        $this->actingAs($customer, 'api')
            ->post('/broadcasting/auth', [
                'channel_name' => 'private-customer.' . $otherCustomer->id,
                'socket_id'    => '1234.5678',
            ])
            ->assertStatus(403);
    }

    public function testAdminCanAccessAnyCustomerChannel()
    {
        $admin = User::factory()->create([
            'role_id' => $this->adminRole->id,
        ]);
        $customer = User::factory()->create([
            'role_id' => $this->customerRole->id,
        ]);

        $this->actingAs($admin, 'api')
            ->post('/broadcasting/auth', [
                'channel_name' => 'private-customer.' . $customer->id,
                'socket_id'    => '1234.5678',
            ])
            ->assertStatus(200);
    }
}
