<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckAdmin
{
    public function handle($request, Closure $next)
    {
        
       
        if(!empty(auth()->guard('admin')->id()))
        {
            $data = DB::table('admins')
                    ->select('admins.usertype','admins.id')
                    ->where('admins.id',auth()->guard('admin')->id())
                    ->get();
            
            if (!$data[0]->id  && $data[0]->usertype != 'W')
            {
                return redirect()->intended('admin/login/')->with('status', '您沒有權限進入後台');
            }
            return $next($request);
        }
        else 
        {
            return redirect()->intended('admin/login/')->with('status', '請登入後台');
        }
        
         
    }
}
