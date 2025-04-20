<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryRecord extends Model
{
    /** @use HasFactory<\Database\Factories\InventoryRecordFactory> */
    use HasFactory;
    // Allow mass assignment for these attributes
    protected $fillable = [
        'item_type',
        'item_name',
        'quantity_in',
        'quantity_out',
        'storage_location',
        'record_date',
    ];
}
