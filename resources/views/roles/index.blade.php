@extends('layouts.app')

@section('title', 'Roles')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            Roles
        </h2>

        @permission('Add Role')
        <button
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#roleModal">

            + Add Role

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

                    @if(
                        auth()->user()->hasPermission('Edit Role') ||
                        auth()->user()->hasPermission('Assign Permissions') ||
                        auth()->user()->hasPermission('Delete Role')
                    )
                    <th width="250">Actions</th>
                    @endif

                </tr>

            </thead>


            <tbody>


            @forelse($roles as $role)


                <tr>


                    <td>
                        {{ $role->id }}
                    </td>


                    <td>
                        {{ $role->name }}
                    </td>


                    <td>
                        {{ $role->description }}
                    </td>


                    @if(
                        auth()->user()->hasPermission('Edit Role') ||
                        auth()->user()->hasPermission('Assign Permissions') ||
                        auth()->user()->hasPermission('Delete Role')
                    )

                    <td>

                        @permission('Edit Role')

                        <a href="{{ route('roles.edit',$role) }}"
                        class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        @endpermission

                        @permission('Assign Permissions')

                        <a href="{{ route('roles.permissions',$role) }}"
                        class="btn btn-info btn-sm">

                            Permissions

                        </a>

                        @endpermission

                        @permission('Delete Role')

                        <form action="{{ route('roles.destroy',$role) }}"
                            method="POST"
                            class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this role?')">

                                    Delete

                            </button>

                        </form>

                        @endpermission

                    </td>

                    @endif

                </tr>

            @empty


                <tr>

                    <td colspan="4"
                        class="text-center">

                        No Roles Found

                    </td>

                </tr>


            @endforelse



            </tbody>


        </table>


    </div>


    {{ $roles->links() }}



</div>





<!-- Role Modal -->
@if(auth()->user()->hasPermission('Add Role') || isset($editRole))

<div class="modal fade"
     id="roleModal"
     tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            @if(isset($editRole))

                <form action="{{ route('roles.update',$editRole) }}"
                      method="POST">

                    @csrf
                    @method('PUT')

            @else

                <form action="{{ route('roles.store') }}"
                      method="POST">

                    @csrf

            @endif

            <div class="modal-header">

                <h5 class="modal-title">

                    @if(isset($editRole))

                        Edit Role

                    @else

                        Add Role

                    @endif

                </h5>

                <button type="button"
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
                        value="{{ old('name',$editRole->name ?? '') }}">

                </div>

                <div class="mb-3">
                    <label class="form-label">

                        Description

                    </label>

                    <textarea
                        name="description"
                        class="form-control"
                        rows="3">{{ old('description',$editRole->description ?? '') }}</textarea>

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
                    class="btn btn-primary">


                    @if(isset($editRole))

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



@if(isset($editRole))

<script>

document.addEventListener('DOMContentLoaded', function(){

    let modal = new bootstrap.Modal(
        document.getElementById('roleModal')
    );

    modal.show();

});

</script>

@endif



@endsection