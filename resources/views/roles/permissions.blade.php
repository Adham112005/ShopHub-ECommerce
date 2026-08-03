@extends('layouts.app')

@section('title','Role Permissions')


@section('content')

<div class="container">

<h2 class="mb-4">
    Permissions: {{ $role->name }}
</h2>


<form action="{{ route('roles.permissions.update',$role) }}"
      method="POST">

@csrf


<div class="row">

@foreach($permissions as $permission)

<div class="col-md-4 mb-3">

<div class="form-check">

<input
class="form-check-input"
type="checkbox"
name="permissions[]"
value="{{ $permission->id }}"

@if($role->permissions->contains($permission->id))

checked

@endif
>


<label class="form-check-label">

{{ $permission->name }}

</label>


</div>

</div>

@endforeach

</div>



<button class="btn btn-primary">

Save Permissions

</button>


</form>


</div>


@endsection