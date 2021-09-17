<?php

namespace Tests\Feature;

use App\Models\Inventory;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\Rules\In;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    /** @test */
    public function an_item_can_be_added_to_an_inventory()
    {
        // Arrange -- setup
        $user = User::factory()->create();
        $inventory = Inventory::factory()
            ->for($user)
            ->create();
        $item_info = [
            'name' => 'Eggs',
            'quantity' => 12
        ];
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
        $user = User::factory()->create();
        $inventory = Inventory::factory()
            ->for($user)
            ->create();
        $items = Item::factory()
            ->for($inventory)
            ->count(3)
            ->create();
        $this->assertEquals(3, $inventory->items->count());
        $unauthorized_user = User::factory()->create();

        // Act
        $response = $this
            ->actingAs($unauthorized_user)
            ->post('/inventory/' . $inventory->id . '/items', [
                'name' => 'Eggs',
                'quantity' => 12
            ]);

        // Assert
        $response->assertForbidden();
        $this->assertEquals(3, $inventory->items->fresh()->count());
    }
}
