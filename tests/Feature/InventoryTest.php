<?php

namespace Tests\Feature;

use App\Models\Inventory;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    /** @test */
    public function an_inventory_can_be_created()
    {
        // Arrange
        $user = User::factory()->create();
        $inventory_info = [
            "name" => "Pantry"
        ];
        $this->assertEquals(0, $user->inventories->count());

        // Act
        $this
            ->actingAs($user)
            ->post('/inventories', $inventory_info);

        // Assert
        $this->assertEquals(1, Inventory::all()->count());
    }

    /** @test */
    public function an_inventory_has_to_have_a_name()
    {
        // Arrange
        $inventory_info = [];
        $this->assertEquals(0, Inventory::all()->count());

        // Act
        $response = $this->post('/inventories', $inventory_info);

        // Assert
        $this->assertEquals(0, Inventory::all()->count());
        $this->assertEquals(302, $response->getStatusCode());
    }

    /** @test */
    public function an_inventory_name_can_be_updated()
    {
        // Arrange
        $user = User::factory()
            ->has(Inventory::factory(['name' => 'Pantry']))
            ->create();

        $inventory = $user->inventories->first();
        $this->assertEquals('Pantry', $inventory->name);

        // Act
        $this
            ->actingAs($user)
            ->patch('/inventories/' . $inventory->id, [
            'name' => 'Freezer'
        ]);

        // Assert
        $this->assertEquals('Freezer', $inventory->fresh()->name);
    }

    /** @test */
    public function an_inventory_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        // Arrange
        $user = User::factory()
            ->has(Inventory::factory())
            ->create();
        $this->assertEquals(1, $user->inventories->count());
        $inventory = $user->inventories->first();

        // Act
        $response = $this
            ->actingAs($user)
            ->delete('/inventories/' . $inventory->id);

        // Assert
        $response->assertOk();
        $this->assertEquals(0, $user->inventories->fresh()->count());
    }

    /** @test */
    public function all_items_are_deleted_when_the_inventory_is_deleted()
    {
        // Arrange:
        $user = User::factory()
            ->create();

        $inventory = Inventory::factory()
            ->for($user)
            ->create();

        $items = Item::factory()
            ->count(3)
            ->for($inventory)
            ->create();

        $this->assertEquals(3, $items->count());

        // Act:
        $this
            ->actingAs($user)
            ->delete('/inventories/' . $inventory->id);

        // Assert
        $items->each(function ($item){
            $this->assertDeleted($item);
        });
        $this->assertEquals(0, Inventory::all()->count());
        $this->assertEquals(0, Item::all()->count());
    }

    /** @test */
    public function an_inventory_belongs_to_a_user()
    {
        // Arrange
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $inventory_info = [
            'name' => 'Pantry'
        ];

        // Act
        $this
            ->actingAs($user)
            ->post('/inventories', $inventory_info);

        // Assert
        $this->assertEquals(1, $user->inventories->count());
    }

    /** @test */
    public function a_user_cannot_delete_another_users_inventories()
    {
        // Arrange
        $user = User::factory()
            ->has(Inventory::factory(['name' => 'Pantry']))
            ->create();

        $inventory = $user->inventories->first();

        $unauthorizedInventory = Inventory::factory(['name' => 'Freezer'])
            ->for(User::factory())
            ->create();

        // Act
        $response = $this
            ->actingAs($user)
            ->delete('/inventories/' . $unauthorizedInventory->id);

        // Assert
        $response->assertForbidden();
    }
}
