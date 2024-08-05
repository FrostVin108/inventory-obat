<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stock extends Model
{
    use HasFactory;
    protected $table = 'stocks';
    protected $primaryKey = 'id';

    protected $fillable = [
        'qty',
        'item_id',
    ];
}
