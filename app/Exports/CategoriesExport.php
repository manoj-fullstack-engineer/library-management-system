<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CategoriesExport implements FromCollection, WithHeadings
{
    /**
     * Return the collection of categories to export.
     */
    public function collection()
    {
        // Select only the columns you want to export
        return Category::select('id', 'name', 'created_at', 'updated_at')->get();
    }

    /**
     * Define headings for each column.
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Created At',
            'Updated At',
        ];
    }
}
