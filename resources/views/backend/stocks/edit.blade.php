@extends('layouts.admin')

@section('title', 'Edit Stock Entry')

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4">✏️ Edit Stock Entry</h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('backend.stocks.update', $stock->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @include('backend.stocks._form', [
                        'stock' => $stock,
                        'categories' => $categories,
                    ])

                    <div class="mt-4 d-flex justify-content-center gap-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Update Stock
                        </button>

                        <a href="{{ route('backend.stocks.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i> Exit
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
