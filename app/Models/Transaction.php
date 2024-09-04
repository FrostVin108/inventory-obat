<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    use HasFactory;
    protected $table = 'transactions';
    protected $primaryKey = 'id';

    protected $fillable = [
        'transaction_type',
        'order_id',
        'item_id',
        'qty',
    ];
}
