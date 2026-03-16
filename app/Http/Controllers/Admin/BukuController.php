<?php

namespace App\Http\Controllers\Admin;

use App\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
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
        // hitung jumlah buku yang sedang dipinjam
        $borrowed = DB::table('loan_details')
            ->join('loans', 'loans.id', '=', 'loan_details.loan_id')
            ->where('loan_details.book_id', $id)
            ->where('loans.status', 'borrowed')
            ->sum('qty');

        // validasi jika stock lebih kecil dari buku yang dipinjam
        if ($request->stock < $borrowed) {

            return response()->json([
                'status' => false,
                'message' => 'Stok tidak boleh lebih kecil dari jumlah buku yang sedang dipinjam (' . $borrowed . ')'
            ], 400);
        }

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

        return response()->json([
            'status' => true,
            'message' => 'Buku berhasil diperbarui'
        ]);
    }

    public function destroy($id)
    {
        try {

            $borrowed = DB::table('loan_details')
                ->join('loans', 'loans.id', '=', 'loan_details.loan_id')
                ->where('loan_details.book_id', $id)
                ->where('loans.status', 'borrowed')
                ->count();

            if ($borrowed > 0) {

                return response()->json([
                    'status' => false,
                    'message' => 'Buku tidak bisa dihapus karena masih sedang dipinjam.'
                ]);
            }

            DB::table('books')->where('id', $id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data buku berhasil dihapus.'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

     public function import(Request $request)
    {
        error_reporting(E_ALL ^ E_DEPRECATED ^ E_NOTICE ^ E_WARNING);

        $file = $request->file('file');

        Excel::load($file->getRealPath(), function($reader) {

            $rows = $reader->get();

            // dd($rows);

            foreach ($rows as $row) {

                DB::table('books')->insert([
                    'category_id' => $row->category_id,
                    'title' => $row->title,
                    'author' => $row->author,
                    'publisher' => $row->publisher,
                    'release_year' => $row->release_year,
                    'stock' => $row->stock,
                ]);

            }

        });

        return redirect()->back()->with('success', 'Import berhasil');
    }
}
