<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// PERBAIKAN: Gunakan 't' kecil pada Datatables agar Class ditemukan
use Yajra\Datatables\Facades\Datatables;

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
}
