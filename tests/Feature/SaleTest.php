<?php

use App\Models\Customer;
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
        'sell_price' => 200.00,
        'current_stock' => 50,
    ]);

    $payload = [
        'sale_date' => '2024-01-15',
        'discount' => 50,
        'vat_rate' => 5,
        'paid_amount' => 1000,
        'items' => [
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
    $product = Product::factory()->create(['current_stock' => 10, 'sell_price' => 100]);

    $this->post(route('sales.store'), [
        'customer_id' => $customer->id,
        'sale_date' => '2024-01-15',
        'discount' => 0,
        'vat_rate' => 0,
        'paid_amount' => 0,
        'items' => [
            ['product_id' => $product->id, 'quantity' => 1, 'unit_price' => 100],
        ],
    ])->assertRedirect(route('sales.index'));

    expect(Sale::first()->customer_id)->toBe($customer->id);
});

it('requires at least one line item', function () {
    $this->post(route('sales.store'), [
        'sale_date' => '2024-01-15',
        'discount' => 0,
        'vat_rate' => 5,
        'paid_amount' => 0,
        'items' => [],
    ])->assertSessionHasErrors('items');
});

it('requires valid product ids in line items', function () {
    $this->post(route('sales.store'), [
        'sale_date' => '2024-01-15',
        'discount' => 0,
        'vat_rate' => 5,
        'paid_amount' => 0,
        'items' => [
            ['product_id' => 99999, 'quantity' => 1, 'unit_price' => 100],
        ],
    ])->assertSessionHasErrors('items.0.product_id');
});

it('requires sale date', function () {
    $product = Product::factory()->create(['current_stock' => 10]);

    $this->post(route('sales.store'), [
        'discount' => 0,
        'vat_rate' => 5,
        'paid_amount' => 0,
        'items' => [
            ['product_id' => $product->id, 'quantity' => 1, 'unit_price' => 100],
        ],
    ])->assertSessionHasErrors('sale_date');
});

// ── Journal Entries ───────────────────────────────────────────────────────────

describe('Journal entries', function () {
    it('creates a revenue journal entry for a fully paid sale', function () {
        $product = Product::factory()->create(['sell_price' => 100.00, 'current_stock' => 10]);

        $this->post(route('sales.store'), [
            'sale_date' => '2024-01-15',
            'discount' => 0,
            'vat_rate' => 0,
            'paid_amount' => 100,
            'items' => [
                ['product_id' => $product->id, 'quantity' => 1, 'unit_price' => 100],
            ],
        ])->assertRedirect(route('sales.index'));

        $sale = Sale::first();

        $entry = JournalEntry::where('reference_type', Sale::class)
            ->where('reference_id', $sale->id)
            ->where('description', 'like', '%Revenue%')
            ->first();

        expect($entry)->not->toBeNull();

        $lines = $entry->lines()->with('account')->get();

        // DR Cash = 100
        $cashLine = $lines->first(fn ($l) => $l->account->code === '1001');
        expect($cashLine)->not->toBeNull();
        expect((float) $cashLine->debit)->toBe(100.00);
        expect((float) $cashLine->credit)->toBe(0.00);

        // CR Sales Revenue = 100
        $revLine = $lines->first(fn ($l) => $l->account->code === '4001');
        expect($revLine)->not->toBeNull();
        expect((float) $revLine->credit)->toBe(100.00);
        expect((float) $revLine->debit)->toBe(0.00);
    });

    it('creates a COGS journal entry for a sale', function () {
        $product = Product::factory()->create([
            'sell_price' => 200.00,
            'purchase_price' => 120.00,
            'current_stock' => 10,
        ]);

        $this->post(route('sales.store'), [
            'sale_date' => '2024-01-15',
            'discount' => 0,
            'vat_rate' => 0,
            'paid_amount' => 400,
            'items' => [
                ['product_id' => $product->id, 'quantity' => 2, 'unit_price' => 200],
            ],
        ])->assertRedirect(route('sales.index'));

        $sale = Sale::first();

        $cogsEntry = JournalEntry::where('reference_type', Sale::class)
            ->where('reference_id', $sale->id)
            ->where('description', 'like', '%COGS%')
            ->first();

        expect($cogsEntry)->not->toBeNull();

        $lines = $cogsEntry->lines()->with('account')->get();

        // DR COGS = 2 × 120 = 240
        $cogsLine = $lines->first(fn ($l) => $l->account->code === '5001');
        expect($cogsLine)->not->toBeNull();
        expect((float) $cogsLine->debit)->toBe(240.00);

        // CR Inventory = 240
        $inventoryLine = $lines->first(fn ($l) => $l->account->code === '1003');
        expect($inventoryLine)->not->toBeNull();
        expect((float) $inventoryLine->credit)->toBe(240.00);
    });

    it('records accounts receivable for a partially paid sale', function () {
        $product = Product::factory()->create(['sell_price' => 500.00, 'current_stock' => 5]);

        $this->post(route('sales.store'), [
            'sale_date' => '2024-01-15',
            'discount' => 0,
            'vat_rate' => 0,
            'paid_amount' => 200,
            'items' => [
                ['product_id' => $product->id, 'quantity' => 1, 'unit_price' => 500],
            ],
        ])->assertRedirect(route('sales.index'));

        $sale = Sale::first();

        $entry = JournalEntry::where('reference_type', Sale::class)
            ->where('reference_id', $sale->id)
            ->where('description', 'like', '%Revenue%')
            ->first();

        $lines = $entry->lines()->with('account')->get();

        // DR Cash = 200
        $cashLine = $lines->first(fn ($l) => $l->account->code === '1001');
        expect((float) $cashLine->debit)->toBe(200.00);

        // DR Accounts Receivable = 300
        $arLine = $lines->first(fn ($l) => $l->account->code === '1002');
        expect($arLine)->not->toBeNull();
        expect((float) $arLine->debit)->toBe(300.00);
    });

    it('records vat payable and discount and entry balances', function () {
        $product = Product::factory()->create(['sell_price' => 1000.00, 'current_stock' => 5]);

        // Gross = 1000, Discount = 100, VAT = 900 × 10% = 90, Net = 990
        $this->post(route('sales.store'), [
            'sale_date' => '2024-01-15',
            'discount' => 100,
            'vat_rate' => 10,
            'paid_amount' => 990,
            'items' => [
                ['product_id' => $product->id, 'quantity' => 1, 'unit_price' => 1000],
            ],
        ])->assertRedirect(route('sales.index'));

        $sale = Sale::first();

        $entry = JournalEntry::where('reference_type', Sale::class)
            ->where('reference_id', $sale->id)
            ->where('description', 'like', '%Revenue%')
            ->first();

        $lines = $entry->lines()->with('account')->get();

        // DR Sales Discount = 100
        $discountLine = $lines->first(fn ($l) => $l->account->code === '4002');
        expect($discountLine)->not->toBeNull();
        expect((float) $discountLine->debit)->toBe(100.00);

        // CR VAT Payable = 90
        $vatLine = $lines->first(fn ($l) => $l->account->code === '2001');
        expect($vatLine)->not->toBeNull();
        expect((float) $vatLine->credit)->toBe(90.00);

        // Entry must balance: DR = CR
        $totalDebit = $lines->sum('debit');
        $totalCredit = $lines->sum('credit');
        expect(round((float) $totalDebit, 2))->toBe(round((float) $totalCredit, 2));
    });
});
