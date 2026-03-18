<a href="{{ route('backend.roles.show', $role->id) }}" class="btn btn-outline-info" title="View role">
    <i class="fas fa-eye me-1"></i> View
</a>
<a href="{{ route('backend.roles.edit', $role->id) }}" class="btn btn-outline-warning" title="Edit role">
    <i class="fas fa-edit me-1"></i> Edit
</a>
<form action="{{ route('backend.roles.destroy', $role->id) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-outline-danger" onclick="return confirmDelete(event)" title="Delete role">
        <i class="fas fa-trash-alt me-1"></i> Delete
    </button>
</form>
