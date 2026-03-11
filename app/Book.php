<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'author',
        'publisher',
        'year',
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
}
