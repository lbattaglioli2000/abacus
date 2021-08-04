<?php

namespace App\View\Components;

use App\Models\Inventory;
use Illuminate\View\Component;

class InventoryList extends Component
{
    public $inventories;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->inventories = Inventory::all();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.inventory-list');
    }
}
