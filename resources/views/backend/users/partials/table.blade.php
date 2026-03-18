<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th><input type="checkbox" id="select-all" form="bulkDeleteForm"></th>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td><input type="checkbox" name="selected_users[]" value="{{ $user->id }}" form="bulkDeleteForm">
                    </td>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->roles->pluck('name')->first() ?? '-' }}</td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="d-flex gap-1">
                        <a href="{{ route('backend.users.show', $user) }}" class="btn btn-sm btn-info">Show</a>
                        <a href="{{ route('backend.users.edit', $user) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('backend.users.destroy', $user) }}" method="POST"
                            class="delete-form d-inline" data-user-name="{{ $user->name }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
