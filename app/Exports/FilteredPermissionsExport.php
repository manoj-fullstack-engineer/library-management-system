<?php

namespace App\Exports;

use App\Models\Permission;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Carbon\Carbon;

class FilteredPermissionsExport implements FromCollection, WithHeadings, WithTitle
{
    protected $filters;

    // Accept filter array instead of full Request object
    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Permission::query();

        // Search filter
        if (!empty($this->filters['search'])) {
            $query->where('name', 'like', '%' . $this->filters['search'] . '%');
        }

        // Date range filters
        if (!empty($this->filters['start_date'])) {
            try {
                $startDate = Carbon::createFromFormat('d/m/Y', $this->filters['start_date'])->startOfDay();
                $query->where('created_at', '>=', $startDate);
            } catch (\Exception $e) {
                // Handle date parsing error if needed
            }
        }

        if (!empty($this->filters['end_date'])) {
            try {
                $endDate = Carbon::createFromFormat('d/m/Y', $this->filters['end_date'])->endOfDay();
                $query->where('created_at', '<=', $endDate);
            } catch (\Exception $e) {
                // Handle date parsing error if needed
            }
        }

        // Return formatted data
        return $query->get()->map(function ($permission) {
            return [
                'Permission Name' => $permission->name,
                'Created At' => $permission->created_at->format('d/m/Y'),
            ];
        });
    }

    public function headings(): array
    {
        return ['Permission Name', 'Created At'];
    }

    public function title(): string
    {
        return 'Filtered Permissions';
    }
}
