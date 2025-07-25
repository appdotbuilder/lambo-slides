<?php

namespace Database\Factories;

use App\Models\PresentationCompletion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PresentationCompletion>
 */
class PresentationCompletionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\PresentationCompletion>
     */
    protected $model = PresentationCompletion::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'session_id' => $this->faker->uuid(),
            'completed_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}