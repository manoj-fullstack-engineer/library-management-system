<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'student_library_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'contact_number',
        'enrollment_no',
        'enrollment_date',
        'department',
        'course',
        'year_semester',
        'membership_status',
        'total_books_issued',
        'max_book_limit',
        'fine_amount',
        'blacklist_status',
        'address',
        'date_of_birth',
        'gender',
        'photo',
        'last_login',
        'password',
        'remark',
    ];

    protected $casts = [
        'enrollment_date'     => 'date',
        'date_of_birth'       => 'date',
        'last_login'          => 'datetime',
        'blacklist_status'    => 'boolean',
        'fine_amount'         => 'decimal:2',
        'total_books_issued'  => 'integer',
        'max_book_limit'      => 'integer',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Accessors / Mutators can be added if needed
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }

public function bookIssues()
{
    return $this->hasMany(BookIssue::class, 'student_library_id', 'student_library_id');
}
public function libraryCards()
{
    return $this->hasMany(LibraryCard::class);
}


}
