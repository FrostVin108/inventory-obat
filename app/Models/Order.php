<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'Order';
    protected $primaryKey = 'id';

    protected $fillable = [
        'department',
    ];
}
