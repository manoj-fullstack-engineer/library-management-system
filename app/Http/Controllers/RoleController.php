<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Exports\RolesExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $query = $this->filterRoles($request);
        $roles = $query->latest()->paginate($request->per_page === 'all' ? $query->count() : ($request->per_page ?? 10));
        return view('backend.roles.index', compact('roles'));
    }


    private function filterRoles(Request $request)
    {
        return Role::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->when($request->filled('start_date'), function ($query) use ($request) {
                $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', $request->start_date)->startOfDay();
                $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($request->filled('end_date'), function ($query) use ($request) {
                $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', $request->end_date)->endOfDay();
                $query->whereDate('created_at', '<=', $endDate);
            });
    }



    public function create()
    {
        $permissions = Permission::all();
        return view('backend.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|max:255',
            'permissions' => 'required|array',  // Assuming permissions are being assigned
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create and save the new role
        try {
            $role = Role::create([
                'name' => $request->name,
            ]);

            // Attach permissions if there are any
            if ($request->has('permissions')) {
                $role->permissions()->sync($request->permissions);
            }

            // Redirect with success message
            return redirect()->route('backend.roles.index')->with('success', 'Role created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create role: ' . $e->getMessage());
        }
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray(); // Pass this to view

        return view('backend.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }






    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles')->ignore($role->id),
            ],
            'permissions' => 'required|array',
            'permissions.*' => 'integer|exists:permissions,id'
        ]);

        try {
            // Update role
            $role->update(['name' => $validated['name']]);

            // Convert IDs to names and sync
            $permissionNames = Permission::whereIn('id', $validated['permissions'])
                ->pluck('name')
                ->toArray();
            $role->syncPermissions($permissionNames);

            // Clear relevant cache entries
            Cache::forget('permissions_list');
            Cache::forget("role_permissions_{$role->id}");
            Cache::forget("role_user_count_{$role->id}");

            // Clear permission cache if using Spatie
            Artisan::call('cache:forget spatie.permission.cache');

            return redirect()
                ->route('backend.roles.index')
                ->with('success', 'Role updated successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update role: ' . $e->getMessage());
        }
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('backend.roles.index')->with('success', 'Role deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'selected_roles' => 'required|array',
            'selected_roles.*' => 'required|integer|exists:roles,id'
        ]);

        try {
            Role::whereIn('id', $validated['selected_roles'])
                ->where('name', '!=', 'admin')
                ->delete();


            return redirect()->route('backend.roles.index')
                ->with('success', count($validated['selected_roles']) . ' roles deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete roles: ' . $e->getMessage());
        }
    }


    public function exportExcel(Request $request)
    {
        // Pass the Request to RolesExport
        $roles = $this->filterRoles($request)->get();

        return Excel::download(new RolesExport($request), 'roles_filtered.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $roles = $this->filterRoles($request)->get();
        $pdf = Pdf::loadView('backend.roles.export.pdf', compact('roles'));
        return $pdf->download('roles.pdf');
    }

    // public function print()
    // {
    //     $roles = Role::all();
    //     return view('roles.print', compact('roles'));
    // }

    public function exportFilteredPDF(Request $request)
    {
        $roles = $this->filterRoles($request)->get();

        $pdf = Pdf::loadView('backend.roles.export.pdf', compact('roles'));
        return $pdf->download('filtered-roles.pdf');
    }


    public function show(Role $role)
    {
        // Get fresh permissions (not cached) when in debug mode
        $permissions = app()->environment('local')
            ? Permission::all()
            : Cache::remember('permissions_list', 3600, function () {
                return Permission::all();
            });

        // Get fresh role permissions (shorter cache duration)
        $rolePermissions = Cache::remember("role_permissions_{$role->id}", 300, function () use ($role) {
            return $role->permissions()->pluck('id')->toArray();
        }) ?? [];

        // User count with shorter cache duration
        $userCount = Cache::remember("role_user_count_{$role->id}", 300, function () use ($role) {
            return $role->users()->count();
        });

        return view('backend.roles.show', compact('role', 'permissions', 'rolePermissions', 'userCount'));
    }

    public function print(Request $request)
    {
        $roles = $this->filterRoles($request)->get();
        return view('backend.roles.print', compact('roles'));
    }
}
