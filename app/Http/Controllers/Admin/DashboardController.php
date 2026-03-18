<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;


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
            ->make(true);
    }

    public function chartData()
    {
        // summary
        $totalUsers = DB::table('users')->count();
        $totalBooks = DB::table('books')->count();
        $totalCategories = DB::table('categories')->count();

        // books per category
        $booksPerCategory = DB::table('books')
            ->join('categories', 'categories.id', '=', 'books.category_id')
            ->select('categories.name', DB::raw('COUNT(books.id) as total'))
            ->groupBy('categories.name')
            ->orderBy('categories.name')
            ->get();

        return response()->json([
            'summary' => [
                'users' => $totalUsers,
                'books' => $totalBooks,
                'categories' => $totalCategories
            ],
            'books_per_category' => $booksPerCategory
        ]);
    }
}
