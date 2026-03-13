<?php

namespace App\Services;

use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\Product;
use App\Models\Sale;

class SaleJournalService
{
    /** @var array<string, int> */
    private array $accountIds = [];

    public function record(Sale $sale): void
    {
        $this->loadAccounts();

        $sale->loadMissing('items');

        $this->recordRevenueEntry($sale);
        $this->recordCogsEntry($sale);
    }

    private function loadAccounts(): void
    {
        $this->accountIds = Account::query()
            ->whereIn('code', ['1001', '1002', '1003', '2001', '4001', '4002', '5001'])
            ->pluck('id', 'code')
            ->all();
    }

    private function recordRevenueEntry(Sale $sale): void
    {
        $entry = JournalEntry::create([
            'entry_date' => $sale->sale_date,
            'reference_type' => Sale::class,
            'reference_id' => $sale->id,
            'description' => "Sale #{$sale->id} – Revenue",
        ]);

        $lines = [];

        // DR Cash → amount actually paid
        if ($sale->paid_amount > 0) {
            $lines[] = ['account_id' => $this->accountIds['1001'], 'debit' => $sale->paid_amount, 'credit' => 0];
        }

        // DR Accounts Receivable → outstanding balance
        if ($sale->due_amount > 0) {
            $lines[] = ['account_id' => $this->accountIds['1002'], 'debit' => $sale->due_amount, 'credit' => 0];
        }

        // DR Sales Discount → contra-revenue
        if ($sale->discount > 0) {
            $lines[] = ['account_id' => $this->accountIds['4002'], 'debit' => $sale->discount, 'credit' => 0];
        }

        // CR Sales Revenue → full gross before discount
        // Total DR = paid + due + discount = net_payable + discount = gross + vat ✓
        $lines[] = ['account_id' => $this->accountIds['4001'], 'debit' => 0, 'credit' => $sale->gross_amount];

        // CR VAT Payable
        if ($sale->vat_amount > 0) {
            $lines[] = ['account_id' => $this->accountIds['2001'], 'debit' => 0, 'credit' => $sale->vat_amount];
        }

        $entry->lines()->createMany($lines);
    }

    private function recordCogsEntry(Sale $sale): void
    {
        $purchasePrices = Product::query()
            ->whereIn('id', $sale->items->pluck('product_id'))
            ->pluck('purchase_price', 'id');

        $totalCogs = $sale->items->sum(
            fn ($item) => $item->quantity * (float) ($purchasePrices[$item->product_id] ?? 0)
        );

        if ($totalCogs <= 0) {
            return;
        }

        $entry = JournalEntry::create([
            'entry_date' => $sale->sale_date,
            'reference_type' => Sale::class,
            'reference_id' => $sale->id,
            'description' => "Sale #{$sale->id} – COGS",
        ]);

        $entry->lines()->createMany([
            ['account_id' => $this->accountIds['5001'], 'debit' => $totalCogs, 'credit' => 0],
            ['account_id' => $this->accountIds['1003'], 'debit' => 0,          'credit' => $totalCogs],
        ]);
    }
}
