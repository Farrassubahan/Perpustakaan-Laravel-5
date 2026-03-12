<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Yajra\Datatables\Facades\Datatables;

class BukuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = DB::table('categories')->orderBy('name')->get();
        return view('admin.books.index', compact('categories'));
    }

    public function datatable()
    {
        $query = DB::table('books')
            ->join('categories', 'categories.id', '=', 'books.category_id')
            ->select([
                'books.id',
                'books.title',
                'books.author',
                'categories.name as category',
                'books.publisher',
                'books.release_year',
                'books.stock'
            ]);

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

    public function store(Request $request)
    {
        DB::table('books')->insert([
            'category_id'  => $request->category_id,
            'title'        => $request->title,
            'author'       => $request->author,
            'publisher'    => $request->publisher,
            'release_year' => $request->release_year,
            'stock'        => $request->stock,
            'created_at'   => Carbon::now(),
            'updated_at'   => Carbon::now()
        ]);

        return response()->json(['status' => true, 'message' => 'Buku berhasil disimpan']);
    }

    public function show($id)
    {
        $book = DB::table('books')->where('id', $id)->first();
        return response()->json($book);
    }

    public function update(Request $request, $id)
    {
        DB::table('books')
            ->where('id', $id)
            ->update([
                'category_id'  => $request->category_id,
                'title'        => $request->title,
                'author'       => $request->author,
                'publisher'    => $request->publisher,
                'release_year' => $request->release_year,
                'stock'        => $request->stock,
                'updated_at'   => Carbon::now()
            ]);

        return response()->json(['status' => true, 'message' => 'Buku diperbarui']);
    }

    public function destroy($id)
    {
        DB::table('books')->where('id', $id)->delete();
        return response()->json(['status' => true, 'message' => 'Buku dihapus']);
    }
}
