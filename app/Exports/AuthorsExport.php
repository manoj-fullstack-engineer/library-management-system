<?php

namespace App\Exports;

use App\Models\Author;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AuthorsExport implements FromView
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function view(): View
    {
        $query = Author::query();

        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $authors = $query->orderBy('id', 'desc')->get();

        return view('backend.authors.excel', compact('authors'));
    }
}
