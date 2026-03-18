<?php
namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Http\Controllers\UserController;

class UsersExport implements FromView
{
    public function __construct(protected $filters) {}

    public function view(): View
    {
        $query = User::with('roles');

        // Apply filters (reuse logic)
        $query = app(UserController::class)->applyFilters($query, request());

        $users = $query->orderByDesc('created_at')->get();

        return view('backend.users.exports.excel', compact('users'));
    }
}
