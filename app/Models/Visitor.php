<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'purpose',
        'address',
        'ip_address',
        'country',
        'user_agent',
        'device',
        'browser',
        'referrer',
        'visited_at',
        'created_at'
    ];
}
