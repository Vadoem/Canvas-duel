<?php

namespace App\Http\Controllers;

use App\Models\Цех;
use Illuminate\Http\Request;

class ЦехController extends Controller
{
    public function index()
    {
        $цехи = Цех::all();
        return response()->json($цехи);
    }
}
