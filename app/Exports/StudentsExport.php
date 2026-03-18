<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
{
    protected $search;

    public function __construct($search = null)
    {
        $this->search = $search;
    }

    public function collection()
    {
        $query = Student::query();

        if ($this->search) {
            $search = $this->search;
            $query->where(function($q) use ($search) {
                $q->where('registration_number', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('middle_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('contact_number', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhere('course', 'like', "%{$search}%")
                  ->orWhere('student_library_id', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('id', 'desc')->get([
            'registration_number',
            'registration_date',
            'first_name',
            'middle_name',
            'last_name',
            'email',
            'contact_number',
            'department',
            'course',
            'year_semester',
            'student_library_id',
            'membership_status',
            'total_books_issued',
            'max_book_limit',
            'fine_amount',
            'blacklist_status',
            'address',
            'date_of_birth',
            'gender',
            'last_login',
            'remark',
        ]);
    }

    public function headings(): array
    {
        return [
            'Registration Number',
            'Registration Date',
            'First Name',
            'Middle Name',
            'Last Name',
            'Email',
            'Contact Number',
            'Department',
            'Course',
            'Year/Semester',
            'Student Library ID',
            'Membership Status',
            'Total Books Issued',
            'Max Book Limit',
            'Fine Amount',
            'Blacklist Status',
            'Address',
            'Date of Birth',
            'Gender',
            'Last Login',
            'Remark',
        ];
    }
}
