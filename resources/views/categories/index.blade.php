@extends('layouts.app')

@section('title', 'Categories')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            Categories
        </h2>

        @permission('Add Category')

        <button
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#categoryModal">

            + Add Category

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

                    <th>Slug</th>

                    <th>Status</th>

                    @if(auth()->user()->hasPermission('Edit Category') || auth()->user()->hasPermission('Delete Category'))

                    <th width="180">

                        Actions

                    </th>

                    @endif

                </tr>

            </thead>

            <tbody>

            @forelse($categories as $category)

                <tr>

                    <td>{{ $category->id }}</td>

                    <td>{{ $category->name }}</td>

                    <td>{{ $category->slug }}</td>

                    <td>

                        @if($category->status)

                            <span class="badge bg-success">

                                Active

                            </span>

                        @else

                            <span class="badge bg-danger">

                                Inactive

                            </span>

                        @endif

                    </td>

                    @if(auth()->user()->hasPermission('Edit Category') || auth()->user()->hasPermission('Delete Category'))

                    <td>

                        @permission('Edit Category')

                        <a href="{{ route('categories.edit', $category) }}"
                           class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        @endpermission

                        @permission('Delete Category')

                        <form action="{{ route('categories.destroy', $category) }}"
                              method="POST"
                              class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this category?')">

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

                        No Categories Found

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    {{ $categories->links() }}

</div>

@if(auth()->user()->hasPermission('Add Category') || isset($editCategory))

<div class="modal fade"
     id="categoryModal"
     tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            @if(isset($editCategory))

            <form action="{{ route('categories.update', $editCategory) }}"
                  method="POST">

                @csrf
                @method('PUT')

            @else

            <form action="{{ route('categories.store') }}"
                  method="POST">

                @csrf

            @endif

                <div class="modal-header">

                    <h5 class="modal-title">

                        {{ isset($editCategory) ? 'Edit Category' : 'Add Category' }}

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
                            value="{{ old('name', $editCategory->name ?? '') }}">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Slug

                        </label>

                        <input
                            type="text"
                            name="slug"
                            class="form-control"
                            value="{{ old('slug', $editCategory->slug ?? '') }}">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Description

                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="3">{{ old('description', $editCategory->description ?? '') }}</textarea>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Status

                        </label>

                        <select
                            name="status"
                            class="form-select">

                            <option value="1"
                                @selected(old('status', $editCategory->status ?? 1) == 1)>

                                Active

                            </option>

                            <option value="0"
                                @selected(old('status', $editCategory->status ?? 1) == 0)>

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

                        {{ isset($editCategory) ? 'Update' : 'Save' }}

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endif

@if(isset($editCategory))

<script>

document.addEventListener('DOMContentLoaded', function () {

    let modal = new bootstrap.Modal(
        document.getElementById('categoryModal')
    );

    modal.show();

});

</script>

@endif

@endsection