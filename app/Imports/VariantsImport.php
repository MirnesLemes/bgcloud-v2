<?php

namespace App\Imports;

use App\Models\Products\Variant;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VariantsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Variant([

            'variant_index' => $row['variant_index'],
            'variant_product'=> $row['variant_product'],
            'variant_category'=> $row['variant_category'],
            'variant_uom'=> $row['variant_uom'],
            'variant_packing'=> $row['variant_packing'],
            'variant_brand'=> $row['variant_brand'],
            'variant_origin'=> $row['variant_origin'],
            'variant_code'=> $row['variant_code'],
            'variant_name'=> $row['variant_name'],
            'variant_barcode'=> $row['variant_barcode'],
            'variant_hscode'=> $row['variant_hscode'],
            'uom_quantity'=> $row['uom_quantity'],
            'variant_weight'=> $row['variant_weight'],
            'variant_price'=> $row['variant_price'],
            'variant_taxprice'=> $row['variant_taxprice'],
            'variant_expprice'=> $row['variant_expprice'],
            'variant_expprice_currency'=> $row['variant_expprice_currency'],
            'variant_purprice'=> $row['variant_purprice'],
            'variant_supprice'=> $row['variant_supprice'],
            'variant_supprice_currency'=> $row['variant_supprice_currency'],
            'variant_attr1_index'=> $row['variant_attr1_index'],
            'variant_attr1_value'=> $row['variant_attr1_value'],
            'variant_attr2_index'=> $row['variant_attr2_index'],
            'variant_attr2_value'=> $row['variant_attr2_value'],
            'variant_attr3_index'=> $row['variant_attr3_index'],
            'variant_attr3_value'=> $row['variant_attr3_value'],
            'variant_attr4_index'=> $row['variant_attr4_index'],
            'variant_attr4_value'=> $row['variant_attr4_value'],
            'ordering'=> $row['ordering'],
            'created_by'=> $row['created_by'],
            'updated_by'=> $row['updated_by'],
            
        ]);
    }
}
