<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RolesExportCollection implements FromCollection, WithHeadings
{
    protected $roles;

    public function __construct(Collection $roles)
    {
        $this->roles = $roles;
    }

    public function collection(): Collection
    {
        // Map the collection to extract only the data you want in the Excel sheet
        return $this->roles->map(function ($role) {
            return [
                'ID' => $role->id,
                'Name' => $role->name,
                'Guard Name' => $role->guard_name,
                'Created At' => $role->created_at->format('d/m/Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Guard Name',
            'Created At',
        ];
    }
}
