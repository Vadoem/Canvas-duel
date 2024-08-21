<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\EmployerPractice;
use Illuminate\Http\Request;

class EmployerPracticeController extends Controller
{
    public function index()
    {
        $employerpractice = EmployerPractice::all();
        return response()->json($employerpractice);
    }

    public function store(Request $request)
    {
        $employerpractice = EmployerPractice::create($request->all());
        return response()->json($employerpractice, 201);
    }

    public function update(Request $request, EmployerPractice $employerpractice)
    {
        $employerpractice->update($request->all());
        return response()->json($employerpractice, 200);
    }

    // Добавьте другие методы, если необходимо (удаление и т.д.)
}