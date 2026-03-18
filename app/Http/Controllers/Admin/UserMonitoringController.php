<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Pastikan Carbon di-import di sini
use Datatables; // Gunakan namespace lengkap sesuai package

class UserMonitoringController extends Controller
{
    public function index()
    {
        return view('admin.user-monitoring');
    }

    public function datatable()
    {
        $query = DB::table('users')
            ->select(['id', 'name', 'email', 'last_login_at', 'is_online'])
            ->orderBy('is_online', 'desc')
            ->orderBy('last_login_at', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()

            ->editColumn('last_login_at', function ($row) {
                if (!$row->last_login_at) {
                    return 'Belum login';
                }

                return Carbon::parse($row->last_login_at)->diffForHumans();
            })

            ->addColumn('status', function ($row) {
                return $row->is_online ? 'online' : 'offline';
            })

            ->make(true);
    }
}
