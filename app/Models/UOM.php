<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasONe;


class UOM extends Model
{
    use HasFactory;
    protected $table = 'uoms';
    protected $primaryKey = 'id';

    protected $fillable = [
        'unit_of_measurement',
    ];

}
