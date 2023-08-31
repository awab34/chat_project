@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
           <a href="{{route('create.group')}}">Create A New group</a>
        </div>
    </div>
    @if (count($groups) == 0)
<p>No groups Found</p>
@else
<table>
    <tr>
        <th>Group Name</th>
        <th>Action</th>
    </tr>
    @foreach ($groups as $item)
    <tr><td><a href="{{route('group.show',$item->id)}}">{{$item->group_name}}</a></td>
        @if ($item->admin_id == Auth::id())
        <td><a href="{{route('group.delete',$item->id)}}">delete</a></td>
        @endif
    </tr>
    @endforeach
</table>

   
@endif
</div>
@endsection
