<?php

namespace Database\Factories;

use App\Models\JournalEntry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<JournalEntry>
 */
class JournalEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'entry_date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'reference_type' => null,
            'reference_id' => null,
            'description' => $this->faker->sentence(4),
        ];
    }
}
