<?php

namespace Database\Factories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gross = fake()->randomFloat(2, 100, 5000);
        $discount = fake()->randomFloat(2, 0, 50);
        $vatRate = 5.0;
        $vatAmount = ($gross - $discount) * $vatRate / 100;
        $netPayable = $gross - $discount + $vatAmount;
        $paidAmount = fake()->randomFloat(2, 0, $netPayable);

        return [
            'customer_id'  => null,
            'sale_date'    => fake()->date(),
            'notes'        => null,
            'gross_amount' => $gross,
            'discount'     => $discount,
            'vat_rate'     => $vatRate,
            'vat_amount'   => $vatAmount,
            'net_payable'  => $netPayable,
            'paid_amount'  => $paidAmount,
            'due_amount'   => max(0, $netPayable - $paidAmount),
        ];
    }
}
