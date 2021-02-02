<?php

namespace App\Exports;

use App\Model\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductExport implements FromView
{
    protected $products;

    public function __construct($products){
        $this->products=$products;
    }
    
    public function view(): View
    {
        return view('exports.product_export', [
            'products' => $this->products,
        ]);
    }
}
