@extends('layouts.app')

@section('title', 'Brands')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            Brands
        </h2>

        @permission('Add Brand')

        <button
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#brandModal">

            + Add Brand

        </button>

        @endpermission

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    @if(session('error'))

        <div class="alert alert-danger">

            {{ session('error') }}

        </div>

    @endif

    <div class="table-responsive">

        <table class="table table-bordered table-hover">

            <thead class="table-dark">

                <tr>

                    <th>#</th>

                    <th>Name</th>

                    <th>Status</th>

                    @if(auth()->user()->hasPermission('Edit Brand') || auth()->user()->hasPermission('Delete Brand'))

                    <th width="180">

                        Actions

                    </th>

                    @endif

                </tr>

            </thead>

            <tbody>

            @forelse($brands as $brand)

                <tr>

                    <td>{{ $brand->id }}</td>

                    <td>{{ $brand->name }}</td>

                    <td>

                        @if($brand->status)

                            <span class="badge bg-success">

                                Active

                            </span>

                        @else

                            <span class="badge bg-danger">

                                Inactive

                            </span>

                        @endif

                    </td>

                    @if(auth()->user()->hasPermission('Edit Brand') || auth()->user()->hasPermission('Delete Brand'))

                    <td>

                        @permission('Edit Brand')

                        <a href="{{ route('brands.edit', $brand) }}"
                           class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        @endpermission

                        @permission('Delete Brand')

                        <form action="{{ route('brands.destroy', $brand) }}"
                              method="POST"
                              class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this brand?')">

                                Delete

                            </button>

                        </form>

                        @endpermission

                    </td>

                    @endif

                </tr>

            @empty

                <tr>

                    <td colspan="5" class="text-center">

                        No Brands Found

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    {{ $brands->links() }}

</div>

@if(auth()->user()->hasPermission('Add Brand') || isset($editBrand))

<div class="modal fade"
     id="brandModal"
     tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            @if(isset($editBrand))

            <form action="{{ route('brands.update', $editBrand) }}"
                  method="POST">

                @csrf
                @method('PUT')

            @else

            <form action="{{ route('brands.store') }}"
                  method="POST">

                @csrf

            @endif

                <div class="modal-header">

                    <h5 class="modal-title">

                        {{ isset($editBrand) ? 'Edit Brand' : 'Add Brand' }}

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">

                            Name

                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ old('name', $editBrand->name ?? '') }}">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Description

                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="3">{{ old('description', $editBrand->description ?? '') }}</textarea>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Status

                        </label>

                        <select
                            name="status"
                            class="form-select">

                            <option value="1"
                                @selected(old('status', $editBrand->status ?? 1) == 1)>

                                Active

                            </option>

                            <option value="0"
                                @selected(old('status', $editBrand->status ?? 1) == 0)>

                                Inactive

                            </option>

                        </select>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        {{ isset($editBrand) ? 'Update' : 'Save' }}

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endif

@if(isset($editBrand))

<script>

document.addEventListener('DOMContentLoaded', function () {

    let modal = new bootstrap.Modal(
        document.getElementById('brandModal')
    );

    modal.show();

});

</script>

@endif

@endsection