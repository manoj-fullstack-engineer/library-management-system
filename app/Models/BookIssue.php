<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookIssue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'student_library_id',
        'book_id',
        'due_date',
        'remark',
        'issued_at',
        'issued_by',
        'book_condition',
        'returned_at',
        'total_issued_book_count',
        'book_status',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'due_date'    => 'date',
        'issued_at'   => 'datetime',
        'returned_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array and JSON form.
     */
    protected $appends = [
        'is_overdue',
    ];

    /**
     * Get the student who was issued the book.
     */
    // BookIssue.php
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_library_id', 'student_library_id');
    }


    /**
     * Get the issued book.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the admin/user who issued the book.
     */
    public function issuer()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }
    
public function issuedBy()
{
    return $this->belongsTo(User::class, 'issued_by'); // assuming 'issued_by' column exists
}

    /**
     * Determine if the book issue is overdue.
     */
    public function getIsOverdueAttribute()
    {
        return $this->due_date && now()->gt($this->due_date) && $this->returned_at === null;
    }
}
