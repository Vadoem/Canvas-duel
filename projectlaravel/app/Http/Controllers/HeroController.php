<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class HeroController extends Controller
{
    public function index() {
        return Hero::all();
    }

    public function update(Request $request, $id) {
        $hero = Hero::find($id);
        $hero->update($request->all());
        return response()->json($hero);
    }
}
