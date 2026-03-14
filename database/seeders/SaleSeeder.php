<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Services\SaleJournalService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaleSeeder extends Seeder
{
    /** @var array<string> */
    private array $sampleNotes = [
        'Urgent order — deliver by end of week.',
        'Corporate bulk purchase, invoice required.',
        'Customer picked up in-store.',
        'Delivery arranged for next Monday.',
        'Part of quarterly IT refresh contract.',
        'Gift purchase — include gift receipt.',
        'Replacement for defective unit returned last month.',
        'Pre-order fulfilled ahead of schedule.',
        null,
        null,
        null,
        null,
    ];

    public function run(): void
    {
        $service = app(SaleJournalService::class);
        $customers = Customer::all();
        $products = Product::all();

        if ($customers->isEmpty() || $products->isEmpty()) {
            $this->command->warn('SaleSeeder skipped: no customers or products found.');

            return;
        }

        // Spread 75 sales over the last 6 months
        for ($i = 0; $i < 75; $i++) {
            $saleDate = Carbon::now()->subDays(random_int(1, 180));

            // Pick 1–4 distinct products for this sale
            $itemCount = random_int(1, min(4, $products->count()));
            $pickedProducts = $products->random($itemCount);

            $items = [];
            $grossAmount = 0.0;

            foreach ($pickedProducts as $product) {
                // Refresh current_stock to account for decrements from previous iterations
                $freshProduct = Product::find($product->id);

                if (! $freshProduct || $freshProduct->current_stock < 1) {
                    continue;
                }

                $maxQty = min(5, $freshProduct->current_stock);
                $qty = random_int(1, $maxQty);
                $unitPrice = (float) $freshProduct->sell_price;
                $subtotal = round($qty * $unitPrice, 2);
                $grossAmount += $subtotal;

                $items[] = [
                    'product_id' => $freshProduct->id,
                    'quantity' => $qty,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ];
            }

            if (empty($items)) {
                continue;
            }

            $grossAmount = round($grossAmount, 2);

            // Apply a discount on ~35% of sales (0%, 5%, or 10%)
            $discountRate = [0, 0, 0, 0, 0, 0, 0, 5, 5, 10][random_int(0, 9)];
            $discount = round($grossAmount * $discountRate / 100, 2);

            $vatRate = 5.0;
            $vatAmount = round(($grossAmount - $discount) * $vatRate / 100, 2);
            $netPayable = round($grossAmount - $discount + $vatAmount, 2);

            // Payment split: 65% fully paid, 25% partial, 10% unpaid
            $paymentRoll = random_int(1, 100);

            if ($paymentRoll <= 65) {
                $paidAmount = $netPayable;
            } elseif ($paymentRoll <= 90) {
                $paidAmount = round($netPayable * (random_int(30, 80) / 100), 2);
            } else {
                $paidAmount = 0.0;
            }

            $dueAmount = max(0, round($netPayable - $paidAmount, 2));

            $note = $this->sampleNotes[array_key_first(array_slice($this->sampleNotes, random_int(0, count($this->sampleNotes) - 1), 1, true))];

            DB::transaction(function () use ($service, $customers, $items, $saleDate, $grossAmount, $discount, $vatRate, $vatAmount, $netPayable, $paidAmount, $dueAmount, $note) {
                $sale = Sale::create([
                    'customer_id' => $customers->random()->id,
                    'sale_date' => $saleDate->toDateString(),
                    'notes' => $note,
                    'gross_amount' => $grossAmount,
                    'discount' => $discount,
                    'vat_rate' => $vatRate,
                    'vat_amount' => $vatAmount,
                    'net_payable' => $netPayable,
                    'paid_amount' => $paidAmount,
                    'due_amount' => $dueAmount,
                ]);

                foreach ($items as $item) {
                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'subtotal' => $item['subtotal'],
                    ]);

                    Product::where('id', $item['product_id'])
                        ->where('current_stock', '>=', $item['quantity'])
                        ->decrement('current_stock', $item['quantity']);
                }

                $service->record($sale);
            });
        }
    }
}
