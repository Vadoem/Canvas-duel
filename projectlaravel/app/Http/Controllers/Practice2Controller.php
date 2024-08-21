<?php


namespace App\Http\Controllers;

use App\Models\Practice2; // Импортируем модель Practice2
use Illuminate\Http\Request;
use Fuse\Fuse;

class Practice2Controller extends Controller
{
    public function search(Request $request) {
        $practices2 = Practice2::all(); // Вместо Practice используйте Practice2
        $fuse = new Fuse($practices2->toArray(), [
            'keys' => ['type', 'conditions', 'specialization'],
            'threshold' => 0.3
        ]);

        $results = $fuse->search($request->input('query'));
        return response()->json($results);
    }
}

