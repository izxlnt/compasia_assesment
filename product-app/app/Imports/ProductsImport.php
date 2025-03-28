<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\ShouldQueueWithoutChain;

class ProductsImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueueWithoutChain
{
    public function model(array $row)
    {

        $productId = $row['product_id'] ?? null;
        $status = $row['status'] ?? null;

        if (!$productId || !$status) {
            return null;
        }


        $product = Product::where('id', $productId)->first();

        if ($product) {

            $adjustment = strtolower(trim($status)) === 'buy' ? 1 : -1;


            $product->increment('quantity', $adjustment);
        }

        return null;
    }

    public function chunkSize(): int
    {
        return 2000;
    }
}
