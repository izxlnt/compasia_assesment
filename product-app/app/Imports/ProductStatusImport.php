<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class ProductStatusImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        Log::debug($row);
        $product = Product::where('id', $row['Product ID'])->first();

        if ($product) {
            if ($row['Status'] === 'Sold') {
                $product->quantity = max(0, $product->quantity - 1);
            } elseif ($row['Status'] === 'Buy') {
                $product->quantity += 1;
            }
            $product->save();
        }

        return null;
    }
}
