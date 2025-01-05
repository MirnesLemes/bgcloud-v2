<?php

namespace App\Imports;

use App\Models\Products\Core;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Core([

            'product_index' => $row['product_index'],
            'product_category'=> $row['product_category'],
            'product_brand'=> $row['product_brand'],
            'product_name'=> $row['product_name'],
            'product_description'=> $row['product_description'],
            'product_thumbnail'=> $row['product_thumbnail'],
            'product_attribute1'=> $row['product_attribute1'],
            'product_attribute2'=> $row['product_attribute2'],
            'product_attribute3'=> $row['product_attribute3'],
            'product_attribute4'=> $row['product_attribute4'],
            'ordering'=> $row['ordering'],
            'created_by'=> $row['created_by'],
            'updated_by'=> $row['updated_by'],
            
        ]);
    }
}

