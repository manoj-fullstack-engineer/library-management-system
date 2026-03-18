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
        @foreach ($roles as $index => $role)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $role->name }}</td>
                <td>{{ $role->guard_name }}</td>
                <td>{{ $role->created_at->format('Y-m-d') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>