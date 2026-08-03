@extends('layouts.app')

@section('title','Permissions')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Permissions</h2>

        @permission('Add Permission')
        <button
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#permissionModal">

            + Add Permission

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
                    <th>Description</th>
                    @if(auth()->user()->hasPermission('Edit Permission') || auth()->user()->hasPermission('Delete Permission'))
                    <th width="180">Actions</th>
                    @endif

                </tr>

            </thead>

            <tbody>

            @forelse($permissions as $permission)

                <tr>

                    <td>{{ $permission->id }}</td>

                    <td>{{ $permission->name }}</td>

                    <td>{{ $permission->description }}</td>

                    @if(auth()->user()->hasPermission('Edit Permission') || auth()->user()->hasPermission('Delete Permission'))
                    <td>

                    @permission('Edit Permission')
                        <a href="{{ route('permissions.edit', $permission) }}"
                           class="btn btn-warning btn-sm">

                            Edit

                        </a>
                    @endpermission

                    @permission('Delete Permission')
                        <form action="{{ route('permissions.destroy', $permission) }}"
                              method="POST"
                              class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this permission?')">

                                Delete

                            </button>

                        </form>
                    @endpermission

                    </td>
                    @endif

                </tr>

            @empty

                <tr>

                    <td colspan="4" class="text-center">

                        No Permissions Found

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    {{ $permissions->links() }}

</div>


<!-- Permission Modal -->
@if(auth()->user()->hasPermission('Add Permission') || isset($editPermission))
<div class="modal fade"
     id="permissionModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            @if(isset($editPermission))

                <form action="{{ route('permissions.update', $editPermission) }}"
                      method="POST">

                    @csrf
                    @method('PUT')

            @else

                <form action="{{ route('permissions.store') }}"
                      method="POST">

                    @csrf

            @endif

                <div class="modal-header">

                    <h5 class="modal-title">

                        @if(isset($editPermission))

                            Edit Permission

                        @else

                            Add Permission

                        @endif

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
                            value="{{ old('name', $editPermission->name ?? '') }}">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Description

                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="3">{{ old('description', $editPermission->description ?? '') }}</textarea>

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

                        @if(isset($editPermission))

                            Update

                        @else

                            Save

                        @endif

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
@endif

@if(isset($editPermission))

<script>

document.addEventListener('DOMContentLoaded', function () {

    const modal = new bootstrap.Modal(
        document.getElementById('permissionModal')
    );

    modal.show();

});

</script>

@endif

@endsection