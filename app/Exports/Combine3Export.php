<?php

namespace App\Exports;

use App\Model\Ord;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class Combine3Export implements FromView
{
    protected $ord;

    public function __construct(Ord $ord){
        $this->ord=$ord;
    }
    
    public function view(): View
    {
        $cate=$this->ord->cate;
        $product=$this->ord->product;
        return view('exports.combine3_export', [
            'ord' => $this->ord,
            'product' => $product,
            'cate' => $cate,
        ]);
    }
}
