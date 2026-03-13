<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $query = Sale::query();

        if ($from) {
            $query->whereDate('sale_date', '>=', $from);
        }

        if ($to) {
            $query->whereDate('sale_date', '<=', $to);
        }

        $totals = $query->selectRaw(
            'COUNT(*) as total_sales,
             COALESCE(SUM(gross_amount), 0) as total_gross,
             COALESCE(SUM(discount), 0) as total_discount,
             COALESCE(SUM(vat_amount), 0) as total_vat,
             COALESCE(SUM(net_payable), 0) as total_net,
             COALESCE(SUM(paid_amount), 0) as total_paid,
             COALESCE(SUM(due_amount), 0) as total_due'
        )->first();

        $sales = Sale::query()
            ->with('customer')
            ->when($from, fn ($q) => $q->whereDate('sale_date', '>=', $from))
            ->when($to, fn ($q) => $q->whereDate('sale_date', '<=', $to))
            ->orderByDesc('sale_date')
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('reports.index', compact('totals', 'sales', 'from', 'to'));
    }
}
