<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EnterpriseInfo;
use Illuminate\Http\Request;

class EnterpriseInfoController extends Controller
{
    public function index()
    {
        $enterpriseInfo = EnterpriseInfo::first();

        return response()->json($enterpriseInfo);
    }

    public function store(Request $request)
    {
        $enterpriseInfo = EnterpriseInfo::first();

        if ($enterpriseInfo) {
            $enterpriseInfo->update($request->all());
        } else {
            $enterpriseInfo = EnterpriseInfo::create($request->all());
        }

        return response()->json($enterpriseInfo);
    }
}