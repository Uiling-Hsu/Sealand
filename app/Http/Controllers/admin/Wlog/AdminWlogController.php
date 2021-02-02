<?php

namespace App\Http\Controllers\admin\Wlog;

use App\Model\Wlog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class AdminWlogController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(!has_permission('wlog'))
                abort(403);
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_start_date=Request('search_start_date');
        $search_end_date=Request('search_end_date');
        $search_platform=Request('search_platform');
        $search_keyword=Request('search_keyword');

        $wlogs=Wlog::where('id','>','0');
        if($search_start_date!='') $wlogs=$wlogs->where('created_at','>=',$search_start_date.' 00:00:01');
        if($search_end_date!='') $wlogs=$wlogs->where('created_at','<=',$search_end_date.' 23:59:59');
        if($search_platform!='') $wlogs=$wlogs->where('platform',$search_platform);
        if($search_keyword!='')
            $wlogs=$wlogs->where('user_name', 'like', '%'.$search_keyword.'%')
                ->orWhere('title', 'like', '%'.$search_keyword.'%')
                ->orWhere('content', 'like', '%'.$search_keyword.'%');

        $wlogs=$wlogs->orderBy('id','DESC')->paginate(100);
        return view('admin/wlog/wlog',compact('wlogs','search_start_date', 'search_end_date', 'search_platform', 'search_keyword'));
    }

}
