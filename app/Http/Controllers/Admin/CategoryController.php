<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Facades\Datatables;
use Exception;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        return view('admin.categories.index');
    }

    /**
     * Source Data JSON untuk Datatable
     */
    public function datatable()
    {
        $query = DB::table('categories')->select(['id', 'name']);

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '
                    <button class="btn btn-sm btn-warning edit" data-id="' . $row->id . '">Edit</button>
                    <button class="btn btn-sm btn-danger delete" data-id="' . $row->id . '">Hapus</button>
                ';
            })
            // Hapus baris make(true) jika Anda ingin debug manual
            ->make(true);
    }

    /**
     * Simpan Kategori Baru
     */
    public function store(Request $request)
    {
        DB::table('categories')->insert([
            'name'       => $request->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return response()->json(['status' => true, 'message' => 'Kategori berhasil ditambah']);
    }

    /**
     * Ambil data satu kategori untuk edit
     */
    public function show($id)
    {
        $category = DB::table('categories')->where('id', $id)->first();
        return response()->json($category);
    }

    /**
     * Update data kategori
     */
    public function update(Request $request, $id)
    {
        DB::table('categories')
            ->where('id', $id)
            ->update([
                'name'       => $request->name,
                'updated_at' => Carbon::now()
            ]);

        return response()->json(['status' => true, 'message' => 'Kategori berhasil diupdate']);
    }

    /**
     * Hapus kategori
     */
    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return response()->json(['status' => true, 'message' => 'Kategori berhasil dihapus']);
        } catch (Exception $e) {
            // Menangkap pesan error dari Exception di Model
            return response()->json(['status' => false, 'message' => $e->getMessage()], 422);
        }
    }
}
