<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Datatables;
use Hash;

class UserController extends Controller
{

    /**
     * halaman utama user
     */
    public function index()
    {
        $roles = DB::table('roles')->get();

        return view('admin.users.index', compact('roles'));
    }

    /**
     * datatable user
     */
    public function datatable()
    {
        $query = DB::table('users')
            ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                DB::raw("STRING_AGG(roles.display_name, ', ') as role"),
                'users.created_at'
            )
            ->groupBy(
                'users.id',
                'users.name',
                'users.email',
                'users.created_at'
            );

        return Datatables::of($query)

            ->addIndexColumn()

            ->addColumn('action', function ($row) {

                return '
                <button class="btn btn-sm btn-warning btn-edit" data-id="' . $row->id . '">
                    Edit
                </button>

                <button class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '">
                    Hapus
                </button>
            ';
            })

            ->escapeColumns([])

            ->escapeColumns([])

            ->make(true);
    }


    /**
     * form create user
     */
    public function create()
    {
        $roles = DB::table('roles')->get();

        return view('admin.users.create', compact('roles'));
    }


    /**
     * simpan user
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $userId = DB::table('users')->insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            foreach ($request->role_id as $role) {

                DB::table('role_user')->insert([
                    'user_id' => $userId,
                    'role_id' => $role
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User berhasil dibuat'
            ]);
        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat user'
            ]);
        }
    }


    /**
     * form edit user
     */
    public function edit($id)
    {
        $user = DB::table('users')
            ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'role_user.role_id'
            )
            ->where('users.id', $id)
            ->first();

        return response()->json($user);
    }


    /**
     * update user
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'updated_at' => Carbon::now()
            ];

            if ($request->password) {
                $data['password'] = Hash::make($request->password);
            }

            DB::table('users')
                ->where('id', $id)
                ->update($data);

            DB::table('role_user')
                ->where('user_id', $id)
                ->delete();

            foreach ($request->role_id as $role) {

                DB::table('role_user')->insert([
                    'user_id' => $id,
                    'role_id' => $role
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'User berhasil diupdate');
        } catch (\Exception $e) {

            DB::rollback();

            return back()->with('error', 'Gagal update user');
        }
    }


    /**
     * hapus user
     */
    public function destroy($id)
    {

        if (!userCan('delete_users')) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk menghapus user'
            ], 403);
        }

        DB::beginTransaction();

        try {

            DB::table('role_user')->where('user_id', $id)->delete();

            DB::table('users')->where('id', $id)->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User berhasil dihapus'
            ]);
        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus user'
            ]);
        }
    }
}
