<?php

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

// ── Index ─────────────────────────────────────────────────────────────────────

it('shows the sales index page', function () {
    Sale::factory()->count(3)->create();

    $this->get(route('sales.index'))
        ->assertSuccessful()
        ->assertSee('All Sales');
});

it('redirects guests away from sales index', function () {
    auth()->logout();
    $this->get(route('sales.index'))->assertRedirect(route('login'));
});

// ── Create ────────────────────────────────────────────────────────────────────

it('shows the create sale form', function () {
    $this->get(route('sales.create'))
        ->assertSuccessful()
        ->assertSee('New Sale');
});

// ── Store ─────────────────────────────────────────────────────────────────────

it('records a new sale and decrements stock', function () {
    $product = Product::factory()->create([
        'sell_price'    => 200.00,
        'current_stock' => 50,
    ]);

    $payload = [
        'sale_date'   => '2024-01-15',
        'discount'    => 50,
        'vat_rate'    => 5,
        'paid_amount' => 1000,
        'items'       => [
            ['product_id' => $product->id, 'quantity' => 10, 'unit_price' => 200],
        ],
    ];

    $this->post(route('sales.store'), $payload)
        ->assertRedirect(route('sales.index'));

    // Gross = 10 × 200 = 2000; VAT = (2000 - 50) × 5% = 97.50; Net = 2047.50; Due = 1047.50
    $sale = Sale::first();
    expect($sale)->not->toBeNull();
    expect((float) $sale->gross_amount)->toBe(2000.00);
    expect((float) $sale->discount)->toBe(50.00);
    expect(round((float) $sale->vat_amount, 2))->toBe(97.50);
    expect(round((float) $sale->net_payable, 2))->toBe(2047.50);
    expect((float) $sale->paid_amount)->toBe(1000.00);
    expect(round((float) $sale->due_amount, 2))->toBe(1047.50);

    expect($sale->items()->count())->toBe(1);

    $product->refresh();
    expect($product->current_stock)->toBe(40);
});

it('associates a customer when provided', function () {
    $customer = Customer::factory()->create();
    $product  = Product::factory()->create(['current_stock' => 10, 'sell_price' => 100]);

    $this->post(route('sales.store'), [
        'customer_id' => $customer->id,
        'sale_date'   => '2024-01-15',
        'discount'    => 0,
        'vat_rate'    => 0,
        'paid_amount' => 0,
        'items'       => [
            ['product_id' => $product->id, 'quantity' => 1, 'unit_price' => 100],
        ],
    ])->assertRedirect(route('sales.index'));

    expect(Sale::first()->customer_id)->toBe($customer->id);
});

it('requires at least one line item', function () {
    $this->post(route('sales.store'), [
        'sale_date'   => '2024-01-15',
        'discount'    => 0,
        'vat_rate'    => 5,
        'paid_amount' => 0,
        'items'       => [],
    ])->assertSessionHasErrors('items');
});

it('requires valid product ids in line items', function () {
    $this->post(route('sales.store'), [
        'sale_date'   => '2024-01-15',
        'discount'    => 0,
        'vat_rate'    => 5,
        'paid_amount' => 0,
        'items'       => [
            ['product_id' => 99999, 'quantity' => 1, 'unit_price' => 100],
        ],
    ])->assertSessionHasErrors('items.0.product_id');
});

it('requires sale date', function () {
    $product = Product::factory()->create(['current_stock' => 10]);

    $this->post(route('sales.store'), [
        'discount'    => 0,
        'vat_rate'    => 5,
        'paid_amount' => 0,
        'items'       => [
            ['product_id' => $product->id, 'quantity' => 1, 'unit_price' => 100],
        ],
    ])->assertSessionHasErrors('sale_date');
});
