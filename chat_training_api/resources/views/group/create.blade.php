@extends('layouts.app')

@section('content')
<form action="{{route('group.store')}}" method="POST">
@csrf
<label for="">Group Name</label><input type="text" name="group_name">
<label>Description</label><textarea id="w3review" name="description" rows="4" cols="50"></textarea>
<button type="submit">Create group</button>
</form>
@endsection
