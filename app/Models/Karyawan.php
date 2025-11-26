<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'data_karyawan';

    protected $fillable = [
        'nama',
        'jabatan',
        'alamat',
        'no_telp',
    ];

    public $timestamps = false;
}
