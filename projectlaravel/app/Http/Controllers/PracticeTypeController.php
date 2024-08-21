<?php

namespace App\Http\Controllers;

use App\Models\PracticeType;
use Illuminate\Http\Request;

class PracticeTypeController extends Controller
{
    public function index()
    {
        $practiceTypes = PracticeType::all();
        return response()->json($practiceTypes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $practiceType = PracticeType::create([
            'name' => $request->input('name')
        ]);

        return response()->json($practiceType, 201);
    }
}