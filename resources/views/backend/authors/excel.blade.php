<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Bio</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($authors as $author)
            <tr>
                <td>{{ $author->id }}</td>
                <td>{{ $author->name }}</td>
                <td>{{ $author->email }}</td>
                <td>{{ $author->bio }}</td>
                <td>{{ $author->created_at->format('d-m-Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
