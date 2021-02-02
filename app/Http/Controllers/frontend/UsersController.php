<?php


    namespace App\Http\Controllers\frontend;

    use App\Exports\UserExport;
    use App\Http\Controllers\Controller;
    use App\Model\frontend\User;
    use Maatwebsite\Excel\Facades\Excel;

    class UsersController extends Controller
    {
        public function export()
        {
            $user=User::whereId(8)->first();
            return Excel::download(new UserExport($user), 'users.xlsx');
        }
    }