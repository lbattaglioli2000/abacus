<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
        $this->middleware("owns.inventory");
    }

    public function store(Inventory $inventory, Request $request){
        $item = Item::create($request->all());
        return $inventory->addItem($item);
    }
}
