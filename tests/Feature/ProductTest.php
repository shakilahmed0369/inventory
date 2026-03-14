<?php

use App\Models\Product;
use App\Models\User;
use Database\Seeders\AccountSeeder;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

// ── Index ────────────────────────────────────────────────────────────────────

it('shows the products index page', function () {
    Product::factory()->count(3)->create();

    $this->get(route('products.index'))
        ->assertSuccessful()
        ->assertSee('All Products');
});

it('redirects guests away from products index', function () {
    auth()->logout();
    $this->get(route('products.index'))->assertRedirect(route('login'));
});

// ── Delete ───────────────────────────────────────────────────────────────────

it('deletes a product that has no sale records', function () {
    $product = Product::factory()->create();

    $this->delete(route('products.destroy', $product))
        ->assertRedirect(route('products.index'));

    expect(Product::find($product->id))->toBeNull();
});

it('blocks deleting a product that has sale records', function () {
    $this->seed(AccountSeeder::class);

    $product = Product::factory()->create([
        'sell_price' => 100.00,
        'current_stock' => 10,
    ]);

    $this->post(route('sales.store'), [
        'sale_date' => '2024-01-01',
        'discount' => 0,
        'vat_rate' => 0,
        'paid_amount' => 100,
        'items' => [
            ['product_id' => $product->id, 'quantity' => 1, 'unit_price' => 100],
        ],
    ]);

    $this->delete(route('products.destroy', $product))
        ->assertRedirect(route('products.index'));

    // Product must still exist
    expect(Product::find($product->id))->not->toBeNull();
});
