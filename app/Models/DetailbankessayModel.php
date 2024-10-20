<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailbankessayModel extends Model
{
    public $table = 'detail_bank_essay';
    // Disable the model timestamps
    public $timestamps = false;
    use HasFactory;
    protected $guarded = ['id'];
}
