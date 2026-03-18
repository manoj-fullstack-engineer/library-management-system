@extends('layouts.admin')

@section('title', 'Visitor Management')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Visitor Management</h5>
            <div>
                <button id="deleteSelected" class="btn btn-outline-danger btn-sm">
                    <i class="fas fa-trash-alt me-1"></i> Delete Selected
                </button>
            </div>
        </div>

        <div class="card-body">
            {{-- Filter Section --}}
            @include('backend.visitors.partials.filters')

            {{-- Visitors Table --}}
            <div class="table-responsive">
                <table id="visitor-table" class="table table-bordered table-hover table-striped w-100">
                    @include('backend.visitors.partials.table-header')
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Toast Notification --}}
@include('layouts.partials.toast')
@endsection

@section('styles')
    @include('backend.visitors.partials.styles')
@endsection

@section('scripts')
    @include('backend.visitors.partials.scripts')
@endsection
