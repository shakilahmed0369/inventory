<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            ['code' => '1001', 'name' => 'Cash',                 'type' => 'asset'],
            ['code' => '1002', 'name' => 'Accounts Receivable',  'type' => 'asset'],
            ['code' => '1003', 'name' => 'Inventory',            'type' => 'asset'],
            ['code' => '2001', 'name' => 'VAT Payable',          'type' => 'liability'],
            ['code' => '4001', 'name' => 'Sales Revenue',        'type' => 'revenue'],
            ['code' => '4002', 'name' => 'Sales Discount',       'type' => 'expense'],
            ['code' => '5001', 'name' => 'Cost of Goods Sold',   'type' => 'expense'],
        ];

        foreach ($accounts as $account) {
            Account::firstOrCreate(['code' => $account['code']], $account);
        }
    }
}
