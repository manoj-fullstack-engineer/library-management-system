<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibraryCard extends Model
{
    protected $fillable = [
        'student_id',
        'card_number',
        'issued_count',
        'issued_on',
        'issued_by',
    ];

    protected $casts = [
        'issued_on' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
