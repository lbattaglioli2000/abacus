<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Auth;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('owns.inventory', [
            'except' => ['store']
        ]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'string|required'
        ]);

        $inventory = Auth::user()->createInventory($request->get('name'));

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
