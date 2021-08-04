<?php

namespace Tests\Feature;

use App\Models\Inventory;
use App\Models\Item;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    /** @test */
    public function an_item_can_be_created()
    {
        $this->withoutExceptionHandling();

        // Arrange -- setup
        $inventory = Inventory::factory()->create();

        $item_info = [
            'name' => 'Eggs',
            'quantity' => 12,
            'inventory_id' => $inventory->id
        ];

        $this->assertEquals(1, Inventory::all()->count());
        $this->assertEquals(0, Item::all()->count());

        // Act
        $response = $this->post('/inventory/' . $inventory->id . '/items', $item_info);

        // Assert
        $this->assertEquals(1, Item::all()->count());
        $response->assertCreated();
    }

}
