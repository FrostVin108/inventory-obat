<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

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


    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
    
}
