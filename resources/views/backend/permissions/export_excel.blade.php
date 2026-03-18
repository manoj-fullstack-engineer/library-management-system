<table>
    <thead>
        <tr style="background-color: #f5f5f5;">
            <th>#</th>
            <th>Name</th>
            <th>Guard</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($permissions as $index => $permission)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $permission->name }}</td>
                <td>{{ $permission->guard_name }}</td>
                <td>{{ $permission->created_at->format('Y-m-d') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>