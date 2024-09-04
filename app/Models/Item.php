<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasOne;

class Item extends Model
{
    use HasFactory;
    protected $table = 'items';
    protected $primaryKey = 'id';

    protected $fillable = [
        'item_code',
        'description',
        'unit_of_measurement_id',
        'qty',
    ];

    public function uom(): BelongsTo
    {
        return $this->belongsTo(UOM::class, 'unit_of_measurement_id', 'id');
    }



}
