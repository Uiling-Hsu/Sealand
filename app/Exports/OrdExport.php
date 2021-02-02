<?php

namespace App\Exports;

use App\Model\Ord;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrdExport implements FromView
{
    protected $ords;

    public function __construct($ords){
        $this->ords=$ords;
    }
    
    public function view(): View
    {
        return view('exports.ord_export', [
            'ords' => $this->ords,
        ]);
    }
}
