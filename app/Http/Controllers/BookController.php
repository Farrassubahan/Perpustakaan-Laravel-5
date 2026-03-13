<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Facades\Datatables;

use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myLoans()
    {

        $borrowedBooks = DB::table('loans')
            ->where('status', 'borrowed')
            ->count();

        return view('books.my-loans', compact('borrowedBooks'));
    }



    public function datatableMyLoans()
    {
        $query = DB::table('loans')
            ->join('loan_details', 'loan_details.loan_id', '=', 'loans.id')
            ->join('books', 'books.id', '=', 'loan_details.book_id')
            ->where('loans.user_id', Auth::id())
            ->select([
                'loans.id as loan_id',
                'books.title',
                'books.author',
                'loan_details.qty',
                'loans.loan_date',
                'loans.return_date',
                'loans.status'
            ]);

        return Datatables::of($query)

            ->addIndexColumn()

            ->addColumn('status_label', function ($row) {

                if ($row->status == 'borrowed') {
                    return '<span class="label label-warning">Dipinjam</span>';
                }

                if ($row->status == 'returned') {
                    return '<span class="label label-success">Dikembalikan</span>';
                }

                return '';
            })

            ->addColumn('action', function ($row) {

                if ($row->status == 'borrowed') {

                    return '<button class="btn btn-xs btn-success btn-return" data-id="' . $row->loan_id . '">
                            Kembalikan
                        </button>';
                }

                return '-';
            })

            ->make(true);
    }

    public function returnBook($id)
    {
        DB::beginTransaction();

        try {

            // ambil data loan
            $loan = DB::table('loans')
                ->where('id', $id)
                ->first();

            if (!$loan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data peminjaman tidak ditemukan'
                ], 404);
            }

            // ambil detail buku yang dipinjam
            $details = DB::table('loan_details')
                ->where('loan_id', $id)
                ->get();

            foreach ($details as $detail) {

                // kembalikan stok buku
                DB::table('books')
                    ->where('id', $detail->book_id)
                    ->increment('stock', $detail->qty);
            }

            // update status peminjaman
            DB::table('loans')
                ->where('id', $id)
                ->update([
                    'status' => 'returned',
                    'return_date' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Buku berhasil dikembalikan'
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengembalikan buku'
            ], 500);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
