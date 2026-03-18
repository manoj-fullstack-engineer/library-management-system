<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\User;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\Auth\Factory;

class UserController extends Controller
{
    public function index(Request $request)
    {

        if (!Auth::user()->can('view users')) {
            abort(403);
        }

        // Load all roles for filter dropdown
        $roles = Role::pluck('name', 'id');

        // Apply filters to query
        $query = User::with('roles');
        $users = $this->applyFilters($query, $request);

        // Handle per page
        $perPage = $request->input('per_page', 10);
        $users = $perPage === 'all'
            ? $users->orderByDesc('created_at')->get()
            : $users->orderByDesc('created_at')->paginate((int) $perPage);

        return view('backend.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        //Log::debug('User permissions: ', Auth::user()->getAllPermissions()->pluck('name')->toArray());




        if (!Auth::user()->can('create users')) {
            abort(403);
        }

        $roles = Role::all();
        return view('backend.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('create users')) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Convert role IDs to names
        $roleNames = Role::whereIn('id', $validated['roles'])->pluck('name')->toArray();

        $user->assignRole($roleNames); // or ->syncRoles($roleNames)

        return redirect()->route('backend.users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        if (!Auth::user()->can('view users')) {
            abort(403);
        }

        return view('backend.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if (!Auth::user()->can('edit users')) {
            abort(403);
        }

        $roles = Role::all();
        return view('backend.users.edit', compact('user', 'roles'));
    }

  public function update(Request $request, User $user)
{
    if (!Auth::user()->can('edit users')) {
        abort(403);
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:8|confirmed',
        'roles' => 'required|array|min:1',
        'roles.*' => 'exists:roles,id',
    ]);

    // Update user details
    $updateData = [
        'name' => $validated['name'],
        'email' => $validated['email'],
    ];
    
    if (!empty($validated['password'])) {
        $updateData['password'] = Hash::make($validated['password']);
    }

    $user->update($updateData);

    // Convert role IDs to names before syncing
    $roleNames = Role::whereIn('id', $validated['roles'])->pluck('name')->toArray();
    $user->syncRoles($roleNames);

    return redirect()->route('backend.users.index')->with('success', 'User updated successfully.');
}
    public function destroy(User $user)
    {
        if (!Auth::user()->can('delete users')) {
            abort(403);
        }

        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        $user->delete();

        return redirect()->route('backend.users.index')->with('success', 'User deleted successfully.');
    }

  public function bulkDelete(Request $request)
{
    if (!Auth::user()->can('delete users')) {
        abort(403);
    }

    // Handle both array and comma-separated input
    $userIds = is_array($request->selected_users) 
        ? $request->selected_users
        : explode(',', $request->selected_users);

    $users = User::with('roles')->whereIn('id', $userIds)->get();

    $blocked = [];
    $deleted = 0;
    
    foreach ($users as $user) {
        if ($user->roles->pluck('name')->contains('SuperAdmin')) {
            $blocked[] = $user->name;
            continue;
        }

        if ($user->delete()) {
            $deleted++;
        }
    }

    if ($blocked) {
        return redirect()->back()->with('error', 
            'Deleted '.$deleted.' users. Some users (SuperAdmin) were not deleted: ' . implode(', ', $blocked));
    }

    return redirect()->back()->with('success', 'Successfully deleted '.$deleted.' users.');
}


    public function exportExcel(Request $request)
    {
        if (!Auth::user()->can('view users')) {
            abort(403);
        }

        return Excel::download(new UsersExport($request), 'users.xlsx');
    }

    public function exportPdf(Request $request)
    {
        if (!Auth::user()->can('view users')) {
            abort(403);
        }

        $users = $this->applyFilters(User::with('roles'), $request)->get();
        $pdf = Pdf::loadView('backend.users.exports.pdf', compact('users'));
        return $pdf->download('users.pdf');
    }

    public function print(Request $request)
    {
        if (!Auth::user()->can('view users')) {
            abort(403);
        }

        $query = User::with('roles');
        $users = $this->applyFilters($query, $request)->orderByDesc('created_at')->get();

        return view('backend.users.print', compact('users'));
    }





    public static function applyFilters($query, Request $request)
    {
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('created_from')) {
            $query->whereDate('created_at', '>=', $request->created_from);
        }

        if ($request->filled('created_to')) {
            $query->whereDate('created_at', '<=', $request->created_to);
        }

        if ($request->filled('role')) {
            $query->whereHas('roles', fn($q) => $q->where('name', $request->role));
        }

        return $query;
    }
}
