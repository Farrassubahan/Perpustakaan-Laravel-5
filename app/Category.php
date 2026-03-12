<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Exception;

class Category extends Model
{
    protected $fillable = [
        'name'
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    protected static function boot()
    {
        parent::boot();

        
        static::deleting(function ($category) {
            if ($category->books()->count() > 0) {
                throw new Exception("Kategori ini tidak bisa dihapus karena masih memiliki buku-buku.");
            }
        });
    }
}
