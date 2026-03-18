@extends('layouts.admin')

@section('title', 'Add New Stock')

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4">➕ Add New Stock</h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('backend.stocks.store') }}" method="POST" enctype="multipart/form-data">
                    @include('backend.stocks._form', [
                        'stock' => null,
                        'categories' => $categories,
                    ])

                    <div class="mt-4 text-end text-center">
                        <button type="submit" class="btn btn-success me-2">
                            <i class="bi bi-plus-circle me-1"></i> Save Stock
                        </button>

                        <a href="{{ route('backend.stocks.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> Exit
                        </a>
                    </div>


                </form>
            </div>
        </div>
    </div>
@endsection
