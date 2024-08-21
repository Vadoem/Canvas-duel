<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::all();

        return response()->json($groups);
    }

    public function store(Request $request)
    {
        $group = Group::create($request->all());

        return response()->json($group, 201);
    }
}