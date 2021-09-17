<?php

namespace Database\Factories;

use App\Models\Inventory;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $itemNames = collect([
            "Eggs", "Milk", "Bread", "Orange Juice", "Cheese", "Burgers", "Tomato Soup", "Spaghetti",
            "Peanut Butter", "Jelly", "Butter", "Yogurt", "Strawberries", "Blueberries", "Bananas", "Beer",
            "Wine", "Pepsi", "Honey Nut Cherrios", "Raisin Bran"
        ]);

        return [
            'name' => $itemNames->random(),
            'quantity' => $this->faker->numberBetween(0,50),
        ];
    }
}
