<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookIssueReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_library_id',
        'book_id',
        'return_date',
        'book_condition',
        'fine_amount',
        'return_remark',
    ];

    protected $casts = [
        'return_date' => 'datetime',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_library_id', 'student_library_id');
    }
}
