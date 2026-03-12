<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables; // Pastikan import ini ada di atas
// use DB;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * halaman dashboard
     */
    public function index()
    {
        $user = auth()->user();

        if (!$user || !$user->hasRole('admin')) {

            auth()->logout();

            return redirect()->route('login');
        }

        $categories = DB::table('categories')->orderBy('name')->get();
        return view('admin.dashboard', compact('categories'));
    }


    /**
     * datatable source
     */
    public function datatable(Request $request)
    {
        // Cukup buat query dasarnya saja, jangan di ->get() dulu
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
            ->addIndexColumn() // Otomatis membuat kolom 'DT_Row_Index' untuk nomor urut
            ->make(true);
    }
}
