<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;

class ProductImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv|max:10240' // 10MB max
        ]);

        try {
            Excel::import(new ProductsImport, $request->file('file'));

            return response()->json(['message' => 'File uploaded successfully'], 200)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'POST, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'POST, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        }
    }
}
