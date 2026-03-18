<?php
namespace App\Exports;

use App\Models\BookIssue;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookIssuesExport implements FromCollection, WithHeadings
{
    protected $search;

    public function __construct($search = null)
    {
        $this->search = $search;
    }

    public function collection()
    {
        return BookIssue::with('student')
            ->when($this->search, function ($query) {
                $query->whereHas('student', function ($q) {
                    $q->where('first_name', 'like', "%{$this->search}%")
                      ->orWhere('student_library_id', 'like', "%{$this->search}%");
                });
            })
            ->select('id', 'book_title', 'student_id', 'issued_at', 'due_date', 'status', 'remark')
            ->get()
            ->map(function ($issue) {
                return [
                    'ID' => $issue->id,
                    'Book Title' => $issue->book_title,
                    'Student Name' => optional($issue->student)->first_name . ' ' . optional($issue->student)->last_name,
                    'Issued On' => $issue->issued_at,
                    'Due Date' => $issue->due_date,
                    'Status' => $issue->status,
                    'Remark' => $issue->remark,
                ];
            });
    }

    public function headings(): array
    {
        return ['ID', 'Book Title', 'Student Name', 'Issued On', 'Due Date', 'Status', 'Remark'];
    }
}
