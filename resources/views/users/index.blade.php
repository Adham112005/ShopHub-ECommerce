@extends('layouts.app')

@section('title','Users')

@section('content')


<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            Users
        </h2>

        @permission('Add User')

        <button
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#userModal">

            + Add User

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
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    @if(auth()->user()->hasPermission('Edit User') || auth()->user()->hasPermission('Delete User'))
                    <th width="220">Actions</th>
                    @endif
                </tr>

            </thead>

            <tbody>

            @forelse($users as $user)

                <tr>
                    <td>{{ $user->id }}</td>

                    <td>{{ $user->name }}</td>

                    <td>{{ $user->email }}</td>

                    <td>{{ $user->role->name ?? 'No Role' }}</td>

                    <td>
                        @if($user->status)

                            <span class="badge bg-success">
                                Active
                            </span>

                        @else

                            <span class="badge bg-danger">
                                Inactive
                            </span>

                        @endif
                    </td>

                    @if(auth()->user()->hasPermission('Edit User') || auth()->user()->hasPermission('Delete User'))
                    <td>
                        @permission('Edit User')

                        <a href="{{ route('users.edit', $user) }}"
                        class="btn btn-warning btn-sm">

                            Edit

                        </a>
                        @endpermission

                        @permission('Delete User')
                        <form action="{{ route('users.destroy', $user) }}"
                            method="POST"
                            class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this user?')">

                                    Delete

                            </button>
                        </form>
                        @endpermission
                    </td>
                    @endif
                </tr>

            @empty

                <tr>
                    <td colspan="6"
                        class="text-center">

                        No Users Found

                    </td>
                </tr>

            @endforelse

            </tbody>
        </table>
    </div>

    {{ $users->links() }}

</div>

<!-- User Modal -->

@if(auth()->user()->hasPermission('Add User') || isset($editUser))
<div class="modal fade"
     id="userModal"
     tabindex="-1">

    <div class="modal-dialog">
        <div class="modal-content">

            @if(isset($editUser))

            <form action="{{ route('users.update',$editUser) }}"
                method="POST">

            @csrf

            @method('PUT')

            @else

            <form action="{{ route('users.store') }}"
                method="POST">

            @csrf

            @endif

            <div class="modal-header">

                <h5 class="modal-title">

                @if(isset($editUser))
                    Edit User
                @else
                    Add User
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

        <input type="text"
            name="name"
            class="form-control"
            value="{{ old('name',$editUser->name ?? '') }}">

    </div>

    <div class="mb-3">
        <label class="form-label">

            Email

        </label>

        <input type="email"
            name="email"
            class="form-control"
            value="{{ old('email',$editUser->email ?? '') }}">

    </div>





    <div class="mb-3">

        <label class="form-label">

Phone

</label>


<input type="text"
       name="phone"
       class="form-control"
       value="{{ old('phone',$editUser->phone ?? '') }}">


</div>






<div class="mb-3">


<label class="form-label">

Password

</label>


<input type="password"
       name="password"
       class="form-control">


@if(isset($editUser))

<small class="text-muted">

Leave empty to keep current password

</small>

@endif


</div>






<div class="mb-3">


<label class="form-label">

Role

</label>


<select name="role_id"
        class="form-select">


<option value="">
Select Role
</option>



@foreach($roles as $role)


<option value="{{ $role->id }}"


@if(old('role_id',$editUser->role_id ?? '') == $role->id)

selected

@endif


>

{{ $role->name }}

</option>


@endforeach



</select>


</div>







<div class="mb-3">


<label class="form-label">

Status

</label>


<select name="status"
        class="form-select">


<option value="1">

Active

</option>


<option value="0">

Inactive

</option>


</select>


</div>




</div>






<div class="modal-footer">


<button type="button"
        class="btn btn-secondary"
        data-bs-dismiss="modal">

Cancel

</button>




<button class="btn btn-primary">


@if(isset($editUser))

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







@if(isset($editUser))

<script>

document.addEventListener('DOMContentLoaded',function(){

    let modal = new bootstrap.Modal(
        document.getElementById('userModal')
    );

    modal.show();

});


</script>

@endif




@endsection