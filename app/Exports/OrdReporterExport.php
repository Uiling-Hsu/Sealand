<?php

namespace App\Exports;

use App\Model\Ord;
use App\Model\Partner;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrdReporterExport implements FromView
{
    protected $search_dealer_id;
    protected $search_start_date;
    protected $search_end_date;

    public function __construct($search_dealer_id, $search_start_date, $search_end_date){
        $this->search_dealer_id=$search_dealer_id;
        $this->search_start_date=$search_start_date;
        $this->search_end_date=$search_end_date;
    }

    public function view(): View
    {
        $search_dealer_id=$this->search_dealer_id;
        $start_ords = Ord::where('is_paid2',1)
            ->where('paid2_date', '>=', $this->search_start_date.' 00:00:01')
            ->where('paid2_date', '<=', $this->search_end_date.' 23:59:59')
            ->whereHas('product',function($q) use($search_dealer_id){
                $q->where('dealer_id',$search_dealer_id);
            })
            ->where('is_cancel', 0)
            ->orderBy('paid2_date')
            ->get();
        $start_carplus_commission_ords = Ord::where('is_paid2',1)
            ->where('paid2_date', '>=', $this->search_start_date.' 00:00:01')
            ->where('paid2_date', '<=', $this->search_end_date.' 23:59:59')
            ->where('order_from', 1)
            ->whereHas('product',function($q) use($search_dealer_id){
                $q->where('dealer_id','!=',1)
                    ->where('dealer_id',$search_dealer_id);
            })
            ->where('is_cancel', 0)
            ->orderBy('paid2_date')
            ->get();

        $end_ords = Ord::where('is_paid3',1)
            ->where('paid3_date', '>=', $this->search_start_date.' 00:00:01')
            ->where('paid3_date', '<=', $this->search_end_date.' 23:59:59')
            ->whereHas('product',function($q) use($search_dealer_id){
                $q->where('dealer_id',$search_dealer_id);
            })
            ->where('is_cancel', 0)
            ->orderBy('close_date')
            ->get();
        $end_carplus_commission_ords = Ord::where('is_paid3',1)
            ->where('paid3_date', '>=', $this->search_start_date.' 00:00:01')
            ->where('paid3_date', '<=', $this->search_end_date.' 23:59:59')
            ->where('order_from', 1)
            ->whereHas('product',function($q) use($search_dealer_id){
                $q->where('dealer_id','!=',1)
                    ->where('dealer_id',$search_dealer_id);
            })
            ->where('is_cancel', 0)
            ->orderBy('close_date')
            ->get();
        return view('exports.ord_reporter_export', [
            'search_dealer_id' => $this->search_dealer_id,
            'search_start_date' => $this->search_start_date,
            'search_end_date' => $this->search_end_date,
            'start_ords' => $start_ords,
            'start_carplus_commission_ords' => $start_carplus_commission_ords,
            'end_ords' => $end_ords,
            'end_carplus_commission_ords' => $end_carplus_commission_ords,
        ]);
    }
}
