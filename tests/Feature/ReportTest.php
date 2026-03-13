<?php

use App\Models\Customer;
use App\Models\Sale;
use App\Models\User;
use Database\Seeders\AccountSeeder;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
    $this->seed(AccountSeeder::class);
});

it('shows the reports index page', function () {
    $this->get(route('reports.index'))
        ->assertSuccessful()
        ->assertSee('Financial Report');
});

it('redirects guests away from reports', function () {
    auth()->logout();
    $this->get(route('reports.index'))->assertRedirect(route('login'));
});

it('shows correct totals for all sales', function () {
    Sale::factory()->create([
        'gross_amount' => 1000,
        'discount' => 100,
        'vat_amount' => 45,
        'net_payable' => 945,
        'paid_amount' => 945,
        'due_amount' => 0,
    ]);

    Sale::factory()->create([
        'gross_amount' => 500,
        'discount' => 0,
        'vat_amount' => 0,
        'net_payable' => 500,
        'paid_amount' => 200,
        'due_amount' => 300,
    ]);

    $response = $this->get(route('reports.index'))->assertSuccessful();

    $response->assertSee('1,500.00'); // total gross
    $response->assertSee('1,445.00'); // total net
});

it('filters by date range', function () {
    Sale::factory()->create(['sale_date' => '2024-01-10', 'gross_amount' => 300, 'discount' => 0, 'vat_amount' => 0, 'net_payable' => 300, 'paid_amount' => 300, 'due_amount' => 0]);
    Sale::factory()->create(['sale_date' => '2024-02-15', 'gross_amount' => 700, 'discount' => 0, 'vat_amount' => 0, 'net_payable' => 700, 'paid_amount' => 700, 'due_amount' => 0]);

    $response = $this->get(route('reports.index', ['from' => '2024-02-01', 'to' => '2024-02-28']))
        ->assertSuccessful();

    $response->assertSee('700.00');
    $response->assertDontSee('300.00');
});

it('shows sale transaction rows in the table', function () {
    $customer = Customer::factory()->create(['name' => 'Test Customer']);

    Sale::factory()->create([
        'customer_id' => $customer->id,
        'gross_amount' => 800,
        'discount' => 0,
        'vat_amount' => 0,
        'net_payable' => 800,
        'paid_amount' => 800,
        'due_amount' => 0,
    ]);

    $this->get(route('reports.index'))
        ->assertSuccessful()
        ->assertSee('Test Customer')
        ->assertSee('800.00');
});

it('shows empty state when no sales exist', function () {
    $this->get(route('reports.index'))
        ->assertSuccessful()
        ->assertSee('No sales found');
});
