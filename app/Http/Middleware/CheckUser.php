<?php

    namespace App\Http\Middleware;

    use Closure;

    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;

    class CheckUser
    {
        public function handle($request, Closure $next)
        {

            if(!empty(auth()->guard('user')->id()))
            {
                $data = DB::table('users')
                    ->select('users.id')
                    ->where('users.id',auth()->guard('user')->id())
                    ->get();

                if (!$data[0]->id  )
                {
                    return redirect()->intended('user/login/')->with('status', '您沒有權限進入後台');
                }
                return $next($request);
            }
            else
            {
                return redirect()->intended('user/login/')->with('status', '請登入');
            }
        }
    }
