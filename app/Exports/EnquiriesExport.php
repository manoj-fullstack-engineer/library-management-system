<?php
namespace App\Exports;

use App\Models\Enquiry;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EnquiriesExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Enquiry::query();

        if (!empty($this->filters['name'])) {
            $query->where('name', 'like', '%' . $this->filters['name'] . '%');
        }

        if (!empty($this->filters['created_from'])) {
            $query->whereDate('created_at', '>=', $this->filters['created_from']);
        }

        if (!empty($this->filters['created_to'])) {
            $query->whereDate('created_at', '<=', $this->filters['created_to']);
        }

        return $query->select('id', 'name', 'email', 'message', 'created_at')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Email', 'Message', 'Date'];
    }
}
