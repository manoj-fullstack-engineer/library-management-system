<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;
    protected $serial = 0;
    protected $roles;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $this->roles = Role::with('permissions')
            ->when($this->request->filled('search'), fn ($query) =>
                $query->where('name', 'like', '%' . $this->request->search . '%')
            )
            ->when($this->request->filled('start_date') && $this->request->filled('end_date'), fn ($query) =>
                $query->whereBetween('created_at', [
                    $this->request->start_date . ' 00:00:00',
                    $this->request->end_date . ' 23:59:59',
                ])
            )
            ->orderByDesc('created_at')
            ->get();

        return $this->roles;
    }

    public function headings(): array
    {
        return ['S.No', 'Name', 'Permissions', 'Created At'];
    }

    public function map($role): array
    {
        return [
            ++$this->serial,
            $role->name,
            implode(', ', $role->permissions->pluck('name')->toArray()),
            $role->created_at->format('d/m/Y'), // <-- DD/MM/YYYY format
        ];
    }
}
