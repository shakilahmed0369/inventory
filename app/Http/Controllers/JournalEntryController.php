<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JournalEntryController extends Controller
{
    public function index(Request $request): View
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $entries = JournalEntry::query()
            ->withSum('lines as total_debit', 'debit')
            ->withSum('lines as total_credit', 'credit')
            ->withCount('lines')
            ->when($from, fn ($q) => $q->whereDate('entry_date', '>=', $from))
            ->when($to, fn ($q) => $q->whereDate('entry_date', '<=', $to))
            ->orderByDesc('entry_date')
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('journal-entries.index', compact('entries', 'from', 'to'));
    }

    public function show(JournalEntry $journalEntry): View
    {
        $journalEntry->loadMissing(['lines.account']);

        $reference = null;
        if ($journalEntry->reference_type && $journalEntry->reference_id) {
            $reference = ($journalEntry->reference_type)::find($journalEntry->reference_id);
        }

        return view('journal-entries.show', compact('journalEntry', 'reference'));
    }
}
