<?php

namespace App\Observers;

use App\Models\Inventory;

class InventoryObserver
{
    public function deleted(Inventory $inventory){
        $inventory->items()->delete();
    }
}
