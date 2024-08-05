<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    use HasFactory;

    use HasFactory;
    protected $table = 'transactions';
    protected $primaryKey = 'id';

    protected $fillable = [
        'transaction_type',
        'item_id',
        'qty',
    ];
}
