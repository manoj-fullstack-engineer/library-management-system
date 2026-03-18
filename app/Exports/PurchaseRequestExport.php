<?php

namespace App\Exports;

use App\Models\PurchaseRequest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Http\Request;

class PurchaseRequestExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = PurchaseRequest::with(['category', 'creator']);

        if ($this->request->filled('item_name')) {
            $query->where('item_name', 'like', '%' . $this->request->item_name . '%');
        }

        if ($this->request->filled('requester_id')) {
            $query->where('requested_by', $this->request->requester_id);
        }

        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }

        if ($this->request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $this->request->from_date);
        }

        if ($this->request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $this->request->to_date);
        }

        return $query->get()->map(function ($request, $index) {
            return [
                '#' => $index + 1,
                'Request Number' => $request->request_number,
                'Item Name' => $request->item_name,
                'Author' => $request->author,
                'Publisher' => $request->publisher,
                'ISBN' => $request->isbn,
                'Quantity' => $request->quantity,
                'Estimated Cost' => $request->estimated_cost,
                'Category' => $request->category->name ?? '',
                'Requested By' => $request->creator->name ?? '',
                'Status' => ucfirst($request->status),
                'Remark' => $request->remark,
                'Requested At' => $request->created_at->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            '#',
            'Request Number',
            'Item Name',
            'Author',
            'Publisher',
            'ISBN',
            'Quantity',
            'Estimated Cost',
            'Category',
            'Requested By',
            'Status',
            'Remark',
            'Requested At',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Make the heading row bold
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']]],
            1 => ['fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '1E88E5']]],
        ];
    }
}
