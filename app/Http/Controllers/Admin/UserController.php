<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Datatables;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index');
    }

    public function datatable()
    {
        $query = DB::table('users')
            ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
            ->select([
                'users.id',
                'users.name',
                'users.email',
                'roles.display_name as role',
                'users.created_at'
            ]);

        return Datatables::of($query)
            ->addIndexColumn()
            ->make(true);
    }
}
