<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function datatable(Request $request)
    {
        $query = DB::table('books')
            ->join('categories', 'categories.id', '=', 'books.category_id')
            ->select([
                'books.id',
                'books.title',
                'books.author',
                'books.publisher',
                'books.release_year',
                'books.stock',
                'categories.name as category'
            ]);

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btnStyle = "display: inline-block; padding: 6px 20px; color: white; border-radius: 6px; border: none; cursor: pointer; background-color: #E9B263; font-weight: 500;";

                return '<div style="text-align:center;">
                <button class="btn-detail" data-id="' . $row->id . '" style="' . $btnStyle . '">
                    Detail
                </button>
            </div>';
            })
            ->make(true);
    }

    public function detail($id)
    {
        $book = DB::table('books')
            ->join('categories', 'categories.id', '=', 'books.category_id')
            ->select(
                'books.id',
                'books.title',
                'books.author',
                'books.publisher',
                'books.release_year',
                'books.stock',
                'categories.name as category'
            )
            ->where('books.id', $id)
            ->first();

        return response()->json($book);
    }

    public function storeLoan(Request $request)
    {
        // validasi input
        $this->validate($request, [
            'book_id' => 'required|integer',
            'qty'     => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        try {

            // cek buku
            $book = DB::table('books')
                ->where('id', $request->book_id)
                ->first();

            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku tidak ditemukan'
                ], 404);
            }

            // cek stok
            if ($book->stock < $request->qty) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok buku tidak mencukupi'
                ], 400);
            }

            // insert ke tabel loans
            $loanId = DB::table('loans')->insertGetId([
                'user_id'    => Auth::id(),
                'loan_date'  => date('Y-m-d'),
                'status'     => 'borrowed',
                'return_date' => $request->return_date,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            // insert loan detail
            DB::table('loan_details')->insert([
                'loan_id'    => $loanId,
                'book_id'    => $request->book_id,
                'qty'        => $request->qty,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            // kurangi stok buku
            DB::table('books')
                ->where('id', $request->book_id)
                ->decrement('stock', $request->qty);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Peminjaman berhasil diajukan'
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses peminjaman'
            ], 500);
        }
    }
}
