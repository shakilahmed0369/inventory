<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $now = Carbon::now();
        $thisMonth = $now->copy()->startOfMonth();
        $lastMonth = $now->copy()->subMonth()->startOfMonth();
        $lastMonthEnd = $now->copy()->subMonth()->endOfMonth();

        // ── Stat cards ──────────────────────────────────────────────────────────
        $revenueThisMonth = Sale::query()
            ->whereDate('sale_date', '>=', $thisMonth)
            ->sum('net_payable');

        $revenueLastMonth = Sale::query()
            ->whereBetween('sale_date', [$lastMonth, $lastMonthEnd])
            ->sum('net_payable');

        $salesCountThis = Sale::query()->whereDate('sale_date', '>=', $thisMonth)->count();
        $salesCountLast = Sale::query()->whereBetween('sale_date', [$lastMonth, $lastMonthEnd])->count();

        $totalDue = Sale::query()->where('due_amount', '>', 0)->sum('due_amount');
        $lowStockCount = Product::query()->where('current_stock', '<=', 5)->count();
        $totalCustomers = Customer::query()->count();
        $totalProducts = Product::query()->count();

        // ── Recent sales (last 8) ────────────────────────────────────────────────
        $recentSales = Sale::query()
            ->with('customer')
            ->orderByDesc('sale_date')
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        // ── Top 5 products by units sold ────────────────────────────────────────
        $topProducts = SaleItem::query()
            ->selectRaw('product_id, SUM(quantity) as total_qty, SUM(subtotal) as total_revenue')
            ->with('product:id,name,current_stock')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        // ── Low stock products ───────────────────────────────────────────────────
        $lowStockProducts = Product::query()
            ->where('current_stock', '<=', 5)
            ->orderBy('current_stock')
            ->limit(5)
            ->get(['id', 'name', 'current_stock']);

        return view('dashboard.index', compact(
            'revenueThisMonth', 'revenueLastMonth',
            'salesCountThis', 'salesCountLast',
            'totalDue', 'lowStockCount',
            'totalCustomers', 'totalProducts',
            'recentSales', 'topProducts', 'lowStockProducts',
        ));
    }
}
