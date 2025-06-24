<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;
use App\Models\User;
use App\Models\Status;


class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
	{
		return [
			'name' => $this->faker->word,
			'price' => $this->faker->numberBetween(100, 10000),
			'image_path' => 'dummy.jpg',
			'description' => $this->faker->paragraph,
			'user_id' => User::factory(),
			'status_id' => Status::inRandomOrder()->first()?->id ?? 1,
		];
	}
}