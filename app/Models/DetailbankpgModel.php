<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailbankpgModel extends Model
{
    public $table = 'detail_bank_pg';
    // Disable the model timestamps
    public $timestamps = false;
    use HasFactory;
    protected $guarded = ['id'];
}
