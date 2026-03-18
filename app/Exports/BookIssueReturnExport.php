<?php

namespace App\Exports;

use Illuminate\Http\Request;
use App\Models\BookIssueReturn;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromView;

class BookIssueReturnExport implements FromView
{
    protected $filters;

    public function __construct(Request $request)
    {
        $this->filters = $request;
    }

    public function view(): View
    {
        $query = BookIssueReturn::query();

        // Filters
        if ($this->filters->filled('from_date')) {
            $query->whereDate('return_date', '>=', $this->filters->from_date);
        }

        if ($this->filters->filled('to_date')) {
            $query->whereDate('return_date', '<=', $this->filters->to_date);
        }

        if ($this->filters->filled('student_library_id')) {
            $query->where('student_library_id', $this->filters->student_library_id);
        }

        if ($this->filters->filled('book_id')) {
            $query->where('book_id', $this->filters->book_id);
        }

        if ($this->filters->filled('book_condition')) {
            $query->where('book_condition', $this->filters->book_condition);
        }

        // Sorting
        $query->orderBy(
            $this->filters->get('sort_by', 'return_date'),
            $this->filters->get('order', 'desc')
        );

        $returns = $query->get();

        return view('backend.book-returns.excel', compact('returns'));
    }

    public function exportExcel(Request $request)
    {
        $timestamp = now()->format('Ymd_His');
        return Excel::download(new BookIssueReturnExport($request), "book_return_logs_{$timestamp}.xlsx");
    }
}
