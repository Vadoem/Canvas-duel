<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{
    public function download($filename)
    {
        $path = storage_path('app/public/uploads/' . $filename);

        if (!Storage::exists($path)) {
            abort(404);
        }

        return response()->download($path, $filename, [], 'inline');
    }
}