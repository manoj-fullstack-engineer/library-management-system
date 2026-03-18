@extends('layouts.admin')

@section('title', 'Student Details')

@section('content')
<div class="container">
    {{-- Toast Notification --}}
    @if(session('success'))
        <script>
            Swal.fire({
                toast: true,
                icon: 'success',
                title: '{{ session('success') }}',
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif

    <div class="card shadow rounded">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Student Information</h5>
            <a href="{{ route('backend.students.index') }}" class="btn btn-sm btn-secondary">Back</a>
        </div>

        <div class="card-body">
            {{-- Tabs --}}
            <ul class="nav nav-tabs mb-3" id="studentTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                        type="button" role="tab">Profile</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="academic-tab" data-bs-toggle="tab" data-bs-target="#academic"
                        type="button" role="tab">Academic</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="library-tab" data-bs-toggle="tab" data-bs-target="#library"
                        type="button" role="tab">Library</button>
                </li>
            </ul>

            <div class="tab-content" id="studentTabContent">
                {{-- Profile Info --}}
                <div class="tab-pane fade show active" id="profile" role="tabpanel">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <img src="{{ $student->photo ? asset('storage/' . $student->photo) : asset('images/default-user.png') }}"
                                class="img-thumbnail rounded-circle mb-2" alt="Student Photo" width="150">
                            <p class="fw-semibold mb-1">{{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}</p>
                            <p class="text-muted small mb-0">{{ $student->email }}</p>
                            <p class="text-muted small">{{ $student->contact_number }}</p>
                        </div>
                        <div class="col-md-9">
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <th>Registration No.</th>
                                        <td>{{ $student->registration_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Registration Date</th>
                                        <td>{{ $student->registration_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date of Birth</th>
                                        <td>{{ $student->date_of_birth ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Gender</th>
                                        <td>{{ ucfirst($student->gender) ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td>{{ $student->address ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Academic Info --}}
                <div class="tab-pane fade" id="academic" role="tabpanel">
                    <table class="table table-bordered table-sm">
                        <tbody>
                            <tr>
                                <th>Department</th>
                                <td>{{ $student->department ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Course</th>
                                <td>{{ $student->course ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Year/Semester</th>
                                <td>{{ $student->year_semester ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Library Info --}}
                <div class="tab-pane fade" id="library" role="tabpanel">
                    <table class="table table-bordered table-sm">
                        <tbody>
                            <tr>
                                <th>Library Card No.</th>
                                <td>{{ $student->student_library_id }}</td>
                            </tr>
                            <tr>
                                <th>Membership Status</th>
                                <td>{{ $student->membership_status ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Total Books Issued</th>
                                <td>{{ $student->total_books_issued ?? 0 }}</td>
                            </tr>
                            <tr>
                                <th>Max Book Limit</th>
                                <td>{{ $student->max_book_limit ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Fine Amount</th>
                                <td>₹{{ number_format($student->fine_amount ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Blacklist Status</th>
                                <td>{{ $student->blacklist_status ?? 'No' }}</td>
                            </tr>
                            <tr>
                                <th>Last Login</th>
                                <td>{{ $student->last_login ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Remark</th>
                                <td>{{ $student->remark ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
