<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BanksoalModel extends Model
{
    public $table = 'bank_soal';
    // Disable the model timestamps
    // public $timestamps = false;
    use HasFactory;
    protected $guarded = ['id'];

    // DEFAULT KEY DI UBAH JADI KODE BUKAN ID LAGI
    public function getRouteKeyName()
    {
        return 'kode';
    }
}
