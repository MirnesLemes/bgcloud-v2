<?php

namespace App\Imports;

use App\Models\Products\PriceUpdate;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PricesUpdateImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PriceUpdate([

            'variant_code'=> $row['variant_code'],
            'variant_price'=> $row['variant_price'],
            'variant_taxprice'=> $row['variant_taxprice'],
            
        ]);
    }
}
