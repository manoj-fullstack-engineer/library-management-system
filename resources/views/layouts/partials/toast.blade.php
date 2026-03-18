@if(session('success') || session('error'))
    <script>
        Swal.fire({
            icon: '{{ session("success") ? "success" : "error" }}',
            title: '{{ session("success") ?? session("error") }}',
            toast: false,
            position: 'center',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
        });
    </script>
@endif
