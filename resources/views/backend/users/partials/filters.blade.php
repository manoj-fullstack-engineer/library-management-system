<form method="GET" class="row row-cols-1 row-cols-md-6 g-2 align-items-end mb-4">
    <div class="col">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" value="{{ request('name') }}" class="form-control" placeholder="Search name">
    </div>
    <div class="col">
        <label for="email" class="form-label">Email</label>
        <input type="text" name="email" value="{{ request('email') }}" class="form-control" placeholder="Search email">
    </div>
    <div class="col">
        <label for="created_from" class="form-label">Created From</label>
        <input type="date" name="created_from" value="{{ request('created_from') }}" class="form-control">
    </div>
    <div class="col">
        <label for="created_to" class="form-label">Created To</label>
        <input type="date" name="created_to" value="{{ request('created_to') }}" class="form-control">
    </div>
    <div class="col">
        <label for="role" class="form-label">Role</label>
        <select name="role" class="form-select">
            <option value="">All Roles</option>
            @foreach ($roles as $role)
                <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>
                    {{ $role }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col d-flex gap-2">
        <button type="submit" class="btn btn-primary btn-sm w-100">Filter</button>
        <a href="{{ route('backend.users.index') }}" class="btn btn-outline-secondary btn-sm w-100">Show All</a>
    </div>
</form>