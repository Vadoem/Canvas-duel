<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::all();
        return response()->json($contracts);
    }

    public function store(Request $request)
    {
        $contract = Contract::create($request->all());
        return response()->json($contract, 201);
    }

    public function update(Request $request, Contract $contract)
    {
        $contract->update($request->all());
        return response()->json($contract, 200);
    }

    // Добавьте другие методы, если необходимо (удаление и т.д.)
}