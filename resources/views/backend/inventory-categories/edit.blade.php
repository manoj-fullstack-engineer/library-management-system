@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Edit Inventory Category</h2>

    <form action="{{ route('backend.inventory-categories.update', $inventoryCategory->id) }}" method="POST">
        @method('PUT')
     @include('backend.inventory-categories._form', ['inventoryCategory' => $inventoryCategory])
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
