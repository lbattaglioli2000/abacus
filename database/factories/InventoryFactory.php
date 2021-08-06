<?php

namespace Database\Factories;

use App\Models\Inventory;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Inventory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->getInventoryName()
        ];
    }

    private function getInventoryName(){
        $names = collect([
            'Fridge', 'Pantry', 'Freezer',
            'Basement Freezer', 'Garage Fridge',
            'Medicine Cabinet', 'Bookshelf', 'DVD Shelf',
            'Minibar', 'Spice Cabinet'
        ]);

        return $names->random();
    }
}
