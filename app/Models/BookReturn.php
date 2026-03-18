<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_library_id',
        'book_id',
        'issue_date',
        'return_date',
        'condition_on_return',
        'fine_amount',
        'remark',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_library_id', 'student_library_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    public function librarian()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
