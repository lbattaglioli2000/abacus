<?php

namespace Tests\Feature;

use App\Models\Inventory;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    /** @test */
    public function an_item_can_be_added_to_an_inventory()
    {
        // Arrange -- setup
        $user = User::factory()
            ->has(Inventory::factory())
            ->create();
        $inventory = $user->inventories->first();
        $item_info = [
            'name' => 'Eggs',
            'quantity' => 12
        ];

        $this->assertEquals(1, $user->inventories->count());
        $this->assertEquals(0, $inventory->items->count());

        // Act
        $response = $this->post('/inventory/' . $inventory->id . '/items', $item_info);

        // Assert
        $this->assertEquals(1, $inventory->fresh()->items->count());
        $response->assertCreated();
    }

    /** @test */
    public function an_item_cannot_be_added_to_an_inventory_the_user_does_not_own()
    {
        // Arrange
        $user = User::factory()
            ->has(Inventory::factory()->has(Item::factory()))
            ->create();
        $unauthorized_user = User::factory()->create();
        $inventories = $user->inventories;
        $items = $inventories->first()->items;

        dd($inventories);

        $this->assertEquals(1, $inventories->count());
        $this->assertEquals(0, $unauthorized_user->inventories->count());

        // Act
        $response = $this
            ->actingAs($unauthorized_user)
            ->post('/inventory/' . $inventory->id . '/items', [
                'name' => 'Pantry'
            ]);

        // Assert
        $response->assertUnauthorized();
        $this->assertEquals(1, $user->inventories->count());
        $this->assertEquals(0, $unauthorized_user->inventories->count());
    }

}
