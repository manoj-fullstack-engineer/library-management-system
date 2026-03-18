<?php

namespace App\Exports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Stock::with(['category', 'creator']);

        if (!empty($this->filters['search'])) {
            $query->where('item_name', 'like', '%' . $this->filters['search'] . '%');
        }

        if (!empty($this->filters['inventory_category_id'])) {
            $query->where('inventory_category_id', $this->filters['inventory_category_id']);
        }

        if (!empty($this->filters['vendor'])) {
            $query->where('vendor', 'like', '%' . $this->filters['vendor'] . '%');
        }

        if (!empty($this->filters['from']) && !empty($this->filters['to'])) {
            $query->whereBetween('created_at', [$this->filters['from'], $this->filters['to']]);
        }

        return $query->get()->map(function ($stock) {
            return [
                $stock->id,
                $stock->item_name,
                optional($stock->category)->name,
                $stock->vendor,
                $stock->quantity,
                $stock->amount,
                $stock->quantity * $stock->amount, // total
                $stock->created_at->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'Item Name', 'Category', 'Vendor', 'Quantity', 'Amount', 'Total', 'Created Date'];
    }
}
