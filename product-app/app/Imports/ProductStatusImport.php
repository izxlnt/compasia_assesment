<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductStatusImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $product = Product::where('id', $row['product_id'])->first();
        if ($product) {
            if ($row['status'] === 'Sold') {
                $product->quantity -= $row['quantity'];
            } elseif ($row['status'] === 'Buy') {
                $product->quantity += $row['quantity'];
            }
            $product->save();
        }
        return null;
    }
}
