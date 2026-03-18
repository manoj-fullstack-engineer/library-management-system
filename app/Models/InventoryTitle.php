<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTitle extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // Example future relationship
    // public function stockEntries()
    // {
    //     return $this->hasMany(StockEntry::class);
    // }
}
