<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        const table = $('#visitor-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('backend.visitors.index') }}',
            columns: [{
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false
                }, // 1
                {
                    data: 'id',
                    name: 'id'
                }, // 2
                {
                    data: 'name',
                    name: 'name'
                }, // 3
                {
                    data: 'email',
                    name: 'email'
                }, // 4
                {
                    data: 'phone',
                    name: 'phone'
                }, // 5
                {
                    data: 'ip_address',
                    name: 'ip_address'
                }, // 6
                {
                    data: 'visited_at',
                    name: 'visited_at'
                }, // 7
                {
                    data: 'created_at',
                    name: 'created_at'
                }, // 8
                {
                    data: 'id', // 9
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        return `
                            <a href="/backend/visitors/${data}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            <a href="/backend/visitors/${data}/edit" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="${data}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        `;
                    }
                }
            ],
            order: [
                [7, 'desc']
            ] // Sort by created_at

            error: function(xhr, textStatus, errorThrown) {
                console.error('AJAX Error:', xhr.responseText);
            }
        });

        // SweetAlert2 Delete
        $(document).on('click', '.btn-delete', function() {
            const id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('<form>', {
                        method: 'POST',
                        action: `/backend/visitors/${id}`
                    }).append(
                        $('<input>', {
                            type: 'hidden',
                            name: '_token',
                            value: '{{ csrf_token() }}'
                        }),
                        $('<input>', {
                            type: 'hidden',
                            name: '_method',
                            value: 'DELETE'
                        })
                    ).appendTo('body').submit();
                }
            });
        });
    });
</script>
