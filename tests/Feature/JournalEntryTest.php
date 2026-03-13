<?php

use App\Models\JournalEntry;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Database\Seeders\AccountSeeder;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
    $this->seed(AccountSeeder::class);
});

// ── Index ─────────────────────────────────────────────────────────────────────

it('shows the journal entries index page', function () {
    $this->get(route('journal-entries.index'))
        ->assertSuccessful()
        ->assertSee('All Journal Entries');
});

it('redirects guests away from journal entries', function () {
    auth()->logout();
    $this->get(route('journal-entries.index'))->assertRedirect(route('login'));
});

it('lists journal entries created by a sale', function () {
    $product = Product::factory()->create(['sell_price' => 200.00, 'current_stock' => 10]);

    $this->post(route('sales.store'), [
        'sale_date' => '2024-03-01',
        'discount' => 0,
        'vat_rate' => 0,
        'paid_amount' => 400,
        'items' => [
            ['product_id' => $product->id, 'quantity' => 2, 'unit_price' => 200],
        ],
    ]);

    $this->get(route('journal-entries.index'))
        ->assertSuccessful()
        ->assertSee('Revenue')
        ->assertSee('COGS');
});

it('shows balanced badge on index', function () {
    $product = Product::factory()->create(['sell_price' => 100.00, 'current_stock' => 5]);

    $this->post(route('sales.store'), [
        'sale_date' => '2024-03-01',
        'discount' => 0,
        'vat_rate' => 0,
        'paid_amount' => 100,
        'items' => [['product_id' => $product->id, 'quantity' => 1, 'unit_price' => 100]],
    ]);

    $this->get(route('journal-entries.index'))
        ->assertSuccessful()
        ->assertSee('Yes'); // balanced badge
});

// ── Show ──────────────────────────────────────────────────────────────────────

it('shows the journal entry detail page with lines', function () {
    $product = Product::factory()->create([
        'sell_price' => 300.00,
        'purchase_price' => 180.00,
        'current_stock' => 10,
    ]);

    $this->post(route('sales.store'), [
        'sale_date' => '2024-03-01',
        'discount' => 0,
        'vat_rate' => 0,
        'paid_amount' => 300,
        'items' => [['product_id' => $product->id, 'quantity' => 1, 'unit_price' => 300]],
    ]);

    $entry = JournalEntry::where('description', 'like', '%Revenue%')->first();

    $this->get(route('journal-entries.show', $entry))
        ->assertSuccessful()
        ->assertSee('Cash')
        ->assertSee('Sales Revenue')
        ->assertSee('300.00')
        ->assertSee('Balanced');
});

it('shows the sale reference on the detail page', function () {
    $product = Product::factory()->create(['sell_price' => 100.00, 'current_stock' => 5]);

    $this->post(route('sales.store'), [
        'sale_date' => '2024-03-01',
        'discount' => 0,
        'vat_rate' => 0,
        'paid_amount' => 100,
        'items' => [['product_id' => $product->id, 'quantity' => 1, 'unit_price' => 100]],
    ]);

    $entry = JournalEntry::first();
    $sale = Sale::first();

    $this->get(route('journal-entries.show', $entry))
        ->assertSuccessful()
        ->assertSee("Sale #{$sale->id}");
});

it('redirects guests away from journal entry detail', function () {
    $entry = JournalEntry::factory()->create();

    auth()->logout();
    $this->get(route('journal-entries.show', $entry))->assertRedirect(route('login'));
});
