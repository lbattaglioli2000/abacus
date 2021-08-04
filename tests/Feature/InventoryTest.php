<?php

namespace Tests\Feature;

use App\Models\Inventory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    /** @test */
    public function an_inventory_can_be_created()
    {
        // Arrange
        $inventory_info = [
            "name" => "Pantry"
        ];
        $this->assertEquals(0, Inventory::all()->count());

        // Act
        $this->post('/inventories', $inventory_info);

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
    public function an_inventory_can_be_updated()
    {
        $this->withoutExceptionHandling();

        // Arrange
        $inventory = Inventory::factory()->create();
        $this->assertEquals('Fridge', $inventory->name);


        // Act
        $this->patch('/inventories/' . $inventory->id, [
            'name' => 'Freezer'
        ]);

        // Assert
        $this->assertEquals('Freezer', $inventory->fresh()->name);
    }

    /** @test */
    public function an_inventory_can_be_deleted()
    {
        // Arrange
        $inventory = Inventory::factory()->create();

        // Act
        $this->delete('/inventories/' . $inventory->id);

        // Assert
        $this->assertEquals(0, Inventory::all()->count());
    }
}
