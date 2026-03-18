<?php
namespace App\Exports;

use App\Models\BookReturn;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookReturnExport implements FromCollection, WithHeadings
{
    protected $returns;

    public function __construct($returns)
    {
        $this->returns = $returns;
    }

    public function collection()
    {
        return $this->returns->map(function ($return) {
            return [
                'ID' => $return->id,
                'Library ID' => $return->student_library_id,
                'Student Name' => $return->student->name ?? '-',
                'Book Title' => $return->book->title ?? '-',
                'Issue Date' => $return->issue_date,
                'Return Date' => $return->return_date,
                'Condition' => $return->condition_on_return ?? 'N/A',
                'Fine (₹)' => number_format($return->fine_amount, 2),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Library ID',
            'Student Name',
            'Book Title',
            'Issue Date',
            'Return Date',
            'Condition',
            'Fine (₹)',
        ];
    }
}
