<a href="{{ route('backend.users.show', $user->id) }}" class="btn btn-sm btn-secondary">
    <i class="fas fa-eye"></i>
</a>
<a href="{{ route('backend.users.edit', $user->id) }}" class="btn btn-sm btn-warning">
    <i class="fas fa-edit"></i>
</a>
<form action="{{ route('backend.users.destroy', $user->id) }}" method="POST" class="d-inline"
      onsubmit="return confirm('Are you sure?');">
    @csrf
    @method('DELETE')
    <button class="btn btn-sm btn-danger">
        <i class="fas fa-trash-alt"></i>
    </button>
</form>
