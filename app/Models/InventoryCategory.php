<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryCategory extends Model
{
    // ✅ This tells Laravel the correct table name
    protected $table = 'inventory_categories';

    protected $fillable = ['name', 'description', 'status'];
}
