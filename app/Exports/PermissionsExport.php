<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Permission; // Import the Permission model

class FilteredPermissionsExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        // Directly query the permissions from the model, applying any filters from the request.
        $permissions = Permission::filterPermissions($this->request)->get(); // Assuming you have a scope method on the model

        // Return the view with the filtered permissions data
        return view('backend.permissions.export_excel', compact('permissions'));
    }
}
