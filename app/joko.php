<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Joko extends Model
{
    protected $table = 'jokos';

    protected $fillable = [
        'name',
        'asal_kota',
        'asal_kabupaten'
    ];

    public $timestamps = true;
}