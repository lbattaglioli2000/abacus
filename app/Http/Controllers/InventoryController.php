<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http;

class InventoryController extends Controller
{
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'string|required'
        ]);

        $inventory = Inventory::create($request->all());

        return response($inventory, 201);
    }

    public function update(Inventory $inventory, Request $request){
        $this->validate($request, [
            'name' => 'string|required'
        ]);

        return $inventory->update($request->all());
    }

    public function delete(Inventory $inventory){
        return $inventory->delete();
    }
}
