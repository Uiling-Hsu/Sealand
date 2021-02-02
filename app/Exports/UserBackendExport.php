<?php

namespace App\Exports;

use App\Model\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UserBackendExport implements FromView
{
    protected $users;

    public function __construct($users){
        $this->users=$users;
    }
    
    public function view(): View
    {
        return view('exports.user_backend_export', [
            'users' => $this->users,
        ]);
    }
}
