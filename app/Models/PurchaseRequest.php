<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_number',
        'item_name',
        'author',
        'publisher',
        'isbn',
        'quantity',
        'estimated_cost',
        'inventory_category_id',
        'requested_by',
        'status',
        'remark',
    ];

    /**
     * Relationships
     */

    public function category()
    {
        return $this->belongsTo(InventoryCategory::class, 'inventory_category_id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
}
