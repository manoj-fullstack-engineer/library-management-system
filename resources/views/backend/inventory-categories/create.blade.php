@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Create Inventory Category</h2>

    <form action="{{ route('backend.inventory-categories.store') }}" method="POST">
        @csrf
        @include('backend.inventory-categories._form')
        
        <div class="d-flex justify-content-center mt-3">
            <button type="submit" class="btn btn-success px-4">Create</button>
        </div>
    </form>
</div>
@endsection
