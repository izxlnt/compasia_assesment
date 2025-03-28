<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Jobs\ProcessProductUpload;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductStatusImport;
use App\Imports\ProductsImport;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('id', 'LIKE', "%$searchTerm%");
        }

        return response()->json(['data' => $query->get()]);
    }

}
