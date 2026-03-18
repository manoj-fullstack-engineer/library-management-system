<?php

namespace App\Exports;

use App\Models\Publisher;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PublishersExport implements FromView
{
    protected $search;

    public function __construct($search = null)
    {
        $this->search = $search;
    }

    public function view(): View
    {
        $publishers = Publisher::when($this->search, function ($query) {
            $query->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
                  ->orWhere('phone', 'like', "%{$this->search}%")
                  ->orWhere('country', 'like', "%{$this->search}%");
        })->get();

        return view('backend.publishers.excel', compact('publishers'));
    }
}
