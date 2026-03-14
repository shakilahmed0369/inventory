<?php

use App\Models\Customer;
use App\Models\Sale;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

// ── Index ────────────────────────────────────────────────────────────────────

it('shows the customers index page', function () {
    Customer::factory()->count(3)->create();

    $this->get(route('customers.index'))
        ->assertSuccessful()
        ->assertSee('All Customers');
});

it('redirects guests away from customers index', function () {
    auth()->logout();
    $this->get(route('customers.index'))->assertRedirect(route('login'));
});

// ── Delete ───────────────────────────────────────────────────────────────────

it('deletes a customer that has no sales', function () {
    $customer = Customer::factory()->create();

    $this->delete(route('customers.destroy', $customer))
        ->assertRedirect(route('customers.index'));

    expect(Customer::find($customer->id))->toBeNull();
});

it('allows deleting a customer with existing sales and nullifies the link', function () {
    $customer = Customer::factory()->create();
    $sale = Sale::factory()->create(['customer_id' => $customer->id]);

    $this->delete(route('customers.destroy', $customer))
        ->assertRedirect(route('customers.index'));

    // Customer is gone
    expect(Customer::find($customer->id))->toBeNull();

    // Sale still exists but customer_id is now null
    $sale->refresh();
    expect($sale->customer_id)->toBeNull();
});
