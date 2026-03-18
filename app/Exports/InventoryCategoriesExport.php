<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InventoryCategoriesExport implements FromCollection, WithHeadings
{
    protected $categories;

    public function __construct(Collection $categories)
    {
        $this->categories = $categories;
    }

    public function collection()
    {
        // Format each row with readable status
        return $this->categories->map(function ($item) {
            return [
                'Name' => $item->name,
                'Description' => $item->description,
                'Status' => $item->status ? 'Active' : 'Inactive',
                'Created At' => $item->created_at->format('d M Y'),
            ];
        });
    }

    public function headings(): array
    {
        return ['Name', 'Description', 'Status', 'Created At'];
    }
}
