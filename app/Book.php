<?php

namespace App;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'author',
        'publisher',
        'release_year',
        'stock'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function loanDetails()
    {
        return $this->hasMany(LoanDetail::class);
    }

    public function getStockAttribute()
    {
        $borrowed = DB::table('loan_details')
            ->join('loans', 'loans.id', '=', 'loan_details.loan_id')
            ->where('loan_details.book_id', $this->id)
            ->where('loans.status', 'borrowed')
            ->sum('qty');

        $stock = $this->attributes['stock'] - $borrowed;

        return $stock;
    }
}
