<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_category_id',
        'item_name',
        'quantity',
        'amount',
        'vendor',
        'remark',
        'bill_file_path',
        'status',
        'created_by',
    ];

    /**
     * Get the category this stock belongs to.
     */
    public function category()
    {
        return $this->belongsTo(InventoryCategory::class, 'inventory_category_id');
    }

    /**
     * Get the user who created the stock record.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Accessor: get full URL to the bill file (if exists).
     */
    public function getBillFileUrlAttribute()
    {
        return $this->bill_file_path ? Storage::url($this->bill_file_path) : null;
    }
}
