<?php

namespace App\Http\Controllers;

use App\Models\Практика;
use Illuminate\Http\Request;

class PracticeController extends Controller
{
    public function index()
    {
        $practices = Практика::all();

        return response()->json($practices);
    }
    public function store(Request $request)
    {
        $practices = Практика::create($request->all());

        return response()->json($practices, 201);
    }


  public function show($id)
{
    // Найти конкретную практику по идентификатору
    $practices = Практика::findOrFail($id);

    // Возвращаем найденную практику в виде JSON-ответа
    return response()->json($practices);
}
public function update(Request $request, $id)
{
    $practices = Практика::findOrFail($id);
    $practices->update($request->all());

    return response()->json($practices, 200);
}
public function destroy($id)
{
    // Найти конкретную практику по идентификатору
    $practices = Практика::findOrFail($id);

    // Удалить найденную практику
    $practices->delete();

    // Возвращаем успешный HTTP-ответ без содержимого
    return response()->json(null, 204);
}
}