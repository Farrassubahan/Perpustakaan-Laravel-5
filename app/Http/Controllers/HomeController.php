<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Book;


class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $books = Book::all();

        $totalBooks = $books->count();
 
        $totalStock = $books->sum('stock');

        $borrowedBooks = DB::table('loans')
            ->where('status', 'borrowed')
            ->count();

        return view('home', compact(
            'books',
            'totalBooks',
            'totalStock',
            'borrowedBooks'
        ));
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
                return '<div style="text-align:center;">
                <button class="btn btn-sm btn-info btn-detail" data-id="' . $row->id . '" 
                    style="border-radius: 6px; padding: 4px 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <i class="fa fa-info-circle"></i> Detail
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

        if ($request->qty > 5) {
            return response()->json([
                'success' => false,
                'message' => 'Maksimal peminjaman buku adalah 5'
            ], 400);
        }

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

            // cek apakah user sudah meminjam buku yang sama dan belum dikembalikan
            $existingLoan = DB::table('loans')
                ->join('loan_details', 'loan_details.loan_id', '=', 'loans.id')
                ->where('loans.user_id', Auth::id())
                ->where('loan_details.book_id', $request->book_id)
                ->where('loans.status', 'borrowed')
                ->first();

            if ($existingLoan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah meminjam buku ini dan belum mengembalikannya.'
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
