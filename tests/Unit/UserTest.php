<?php

namespace Tests\Unit;

use App\Models\Inventory;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    /** @test */
    public function a_user_can_create_an_inventory()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $user->createInventory("Pantry");

        // Assert
        $inventories = $user->inventories;
        $this->assertEquals(1, $inventories->count());
        $this->assertEquals("Pantry", $inventories->first()->name);
    }

    /** @test */
    public function a_user_owns_an_inventory()
    {
        // Arrange
        $user = User::factory()
            ->has(Inventory::factory())
            ->create();

        $inventory = $user->inventories->first();
        $user2 = User::factory()->create();

        // Assert
        $this->assertTrue($user->owns($inventory));
        $this->assertFalse($user2->owns($inventory));
    }
}
