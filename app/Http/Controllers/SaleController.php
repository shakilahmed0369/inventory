<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRequest;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Services\SaleJournalService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SaleController extends Controller
{
    public function index(): View
    {
        $sales = Sale::query()
            ->with(['customer', 'items'])
            ->orderByDesc('sale_date')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('sales.index', compact('sales'));
    }

    public function create(): View
    {
        $customers = Customer::query()->orderBy('name')->get(['id', 'name']);
        $products = Product::query()
            ->where('current_stock', '>', 0)
            ->orderBy('name')
            ->get(['id', 'name', 'sell_price', 'current_stock', 'image']);

        return view('sales.create', compact('customers', 'products'));
    }

    public function store(StoreSaleRequest $request): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            // Calculate financials server-side to prevent tampering
            $grossAmount = collect($data['items'])->sum(
                fn ($item) => $item['quantity'] * $item['unit_price']
            );

            $discount = (float) ($data['discount'] ?? 0);
            $vatRate = (float) ($data['vat_rate'] ?? 0);
            $vatAmount = ($grossAmount - $discount) * $vatRate / 100;
            $netPayable = $grossAmount - $discount + $vatAmount;
            $paidAmount = (float) ($data['paid_amount'] ?? 0);
            $dueAmount = max(0, $netPayable - $paidAmount);

            $sale = Sale::create([
                'customer_id' => $data['customer_id'] ?? null,
                'sale_date' => $data['sale_date'],
                'notes' => $data['notes'] ?? null,
                'gross_amount' => $grossAmount,
                'discount' => $discount,
                'vat_rate' => $vatRate,
                'vat_amount' => $vatAmount,
                'net_payable' => $netPayable,
                'paid_amount' => $paidAmount,
                'due_amount' => $dueAmount,
            ]);

            foreach ($data['items'] as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['quantity'] * $item['unit_price'],
                ]);

                Product::where('id', $item['product_id'])
                    ->decrement('current_stock', $item['quantity']);
            }

            app(SaleJournalService::class)->record($sale);
        });

        notyf()->success('Sale recorded successfully.');

        return redirect()->route('sales.index');
    }
}
