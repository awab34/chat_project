@extends('layouts.app')

@section('content')
@if(is_null($group))
    <p>There is no group</p>
@else
@if ($group->admin_id == Auth::id() && count($group->users) == 1)
@if (count($friends) == 0)
<a href="{{route('add.firend')}}">Add Friends</a>
@else 
<form action="{{route('group.update',$group->id)}}" method="POST">
    @csrf
    @method('PUT')
    @foreach ($friends as $item)
    <div class="form-check">
    <input type="checkbox" name="users[]" class="form-check-input"  value="{{ $item['id'] }}" @foreach ($group->users as $user)
        @if ($item['id'] == $user->id)
        {{ 'checked' }}
        @endif
    @endforeach /> <label class="form-check-label">{{$item['name']}}</label>
</div>
    @endforeach
    <button type="submit">Add Users</button>

    </form>
    <br>
    <br>
<p><b>please add Users</b></p>  
@endif

@else
    <p> <b>Group Name:</b> {{$group->group_name}}</p>
    <p> <b>The Users Are:</b></p>
    <ul>
        @foreach ($group->users as $user)
        <li><p>{{$user->name}}</p></li>
        @endforeach
        </ul>
        <form action="{{route('group.update',$group->id)}}" method="POST">
            @csrf
            @method('PUT')
            @foreach ($friends as $item)
            <div class="form-check">
            <input type="checkbox" name="users[]" class="form-check-input"  value="{{ $item['id'] }}" @foreach ($group->users as $user)
                @if ($item['id'] == $user->id)
                {{ 'checked' }}
                @endif
            @endforeach /> <label class="form-check-label">{{$item['name']}}</label>
        </div>
            @endforeach
            <button type="submit">Add Users</button>
        
            </form>
            <br>
            <br>
            @if (count($messages) == 0)
        <p>No Messages Found</p>
        <form action="{{route('message.store')}}" method="POST">
            @csrf
            <input type="hidden" name="receiver_id" value="{{$group->id}}">
            <input type="text" name="message">
            <button type="submit">Send Message</button>
        </form>
        @else
        <ul>
        @foreach ($messages as $item)
        <p><b>{{$item['name']}}:</b>  {{$item['message']}} @if ($item['senderId'] == Auth::id() || Auth::id() ==$group->admin_id)
            <a href="{{route('message.delete',$item['id'])}}">Delete</a>
            @endif</p>
        @endforeach
        </ul>  
        <form action="{{route('message.store')}}" method="POST">
            @csrf
            <input type="hidden" name="receiver_id" value="{{$group->id}}">
            <input type="text" name="message">
            <button type="submit">Send Message</button>
        </form>  
        @endif
        @endif
@endif





@endsection
