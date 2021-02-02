<?php

namespace App\Http\Controllers\admin\Holiday;

use App\Http\Requests;
use App\Model\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Holiday\AdminHolidayRequest;
use App\Http\Controllers\Controller;

class AdminHolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $holidays=Holiday::orderBy('holiday_date')->get();
        return view('/admin/holiday/holiday',compact('holidays'));
    }

    public function create(){
        // if(Auth::guest()){
        //     return redirect('articles');
        // }
        return view('/admin/holiday/holiday_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminHolidayRequest $request)
    {
        $inputs=$request->all();
        $holiday_date=$inputs['holiday_date'];
        $keepdays=$inputs['keepdays'];
        if(!$keepdays)
        	$keepdays=1;
        $count=0;
        for($i=0;$i<$keepdays;$i++){
        	$inputs['holiday_date']=date('Y-m-d',strtotime('+'.$i.' day',strtotime($holiday_date)));
        	$holi_cnt=Holiday::where('holiday_date',$inputs['holiday_date'])->count();
        	if(!$holi_cnt){
        		$holiday=Holiday::create($inputs);
        		$count++;
        	}
        }
        Session::flash('flash_message', '應新增'.$keepdays.'天, 實際新增'.$count.'天 (有可能之前已新增過日期)');
        // flash()->overlay('新增成功!','系統訊息:');
        return redirect('/admin/holiday');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Holiday $holiday)
    {
        return view('/admin/holiday/holiday_edit',compact('holiday'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminHolidayRequest $request, Holiday $holiday)
    {
        $inputs=$request->all();
        $holiday->update($inputs);
        //writeLog('更新 假日或補班',$holiday);
        Session::flash('flash_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/holiday?bid='.$holiday->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Holiday $holiday)
    {
        $holiday->delete();
        //writeLog('Delete 假日',$holiday);
        Session::flash('flash_message', '刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/holiday');
    }

    public function checkupdate(Request $request){
        $ids=$request->id;
        $isdels=$request->isdel;
        $succ=false;

        if($isdels){
            foreach ($isdels as $isdel) {
                $holiday=Holiday::whereId($isdel)->first();
                $holiday->delete();
            }
            $succ=true;
        }
        if($succ)
        	Session::flash('flash_message', '批次刪除成功!');
            // flash()->overlay('批次刪除成功!','系統訊息:');
        else
        	Session::flash('flash_message', '請勾選要更新的項目!');
            // flash()->overlay('請勾選要更新的項目, !','系統訊息:');
        return redirect('/admin/holiday?page='.Request('page'));
    }

}
