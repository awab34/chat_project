<?php

namespace App\Http\Controllers;

use App\Models\group;
use Illuminate\Http\Request;
use App\Models\massage;
use App\Models\User;
use Auth;
use App\Models\friend;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class GroupController extends Controller
{
   
    
    public function index()
    {
        $user = Auth::user();
        $groups = $user->groups;
        return response([
            'user' => $user,
            'groups' => $groups
        ]);
    }
    public function showAllChats()
    {
        $user = Auth::user();
        $groups = $user->groups;
        $secondFriends = friend::where('first_freind_id',Auth::id())->get()->each(function ($friend, $key) {
            $user = User::find($friend->second_freind_id);
            
            return ['id'=>$friend->id,'name'=>$user->name];
        });
        $firstFriends = friend::where('second_freind_id',Auth::id())->get()->each(function ($friend, $key) {
            $user = User::find($friend->first_freind_id);
            return ['id'=>$friend->id,'name'=>$user->name];
        });

        
        $friendsArray = [];
        foreach ($firstFriends as $friend) {
            $user = User::find($friend->first_freind_id);
            $friendsArray[] =  ['id'=>$friend->first_freind_id,'name'=>$user->name];
        }
        foreach ($secondFriends as $friend) {
            $user = User::find($friend->second_freind_id);
            $friendsArray[] =  ['id'=>$friend->second_freind_id,'name'=>$user->name];
        }
        return response([
            'groups' => $groups,
            'friends'=>$friendsArray,
            'responseState' => true
        ]);
    }

    public function create()
    {
        return view('group.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'group_name' => 'required|string',
            'description' => 'required|string',
        ]);
        $group = group::create([
            'group_name'=>$request->group_name,
            'description'=>$request->description,
            'admin_id'=>Auth::id(),
        ]);
        if(!is_null($request->users)){
            foreach($request->users as $user){
                $userArray[] = $user;
            }
        }
        $userArray[] = strval(Auth::id());
        $group->users()->attach($userArray);
        return response([
            'success' => true
        ],200);
    }

    public function showGroupInfo($id){
        $group = group::where('id',$id)->first();
        $groupAdmin = User::find($group->admin_id);
        $group->users;
        return response(['group'=>$group,'admin'=>$groupAdmin,'userId'=>Auth::id()],200);
    }
    
    public function show($id)
    {
        $group = group::where('id',$id)->first();
        $group->users;
        $messages = massage::where('receiver_id',$id)->where('receiver_type',2)->get();
        $secondFriends = friend::where('first_freind_id',Auth::id())->get();
        $firstFriends = friend::where('second_freind_id',Auth::id())->get();
        $friendsArray = [];
        foreach ($firstFriends as $friend) {
            $user = User::find($friend->first_freind_id);
            $friendsArray[] =  ['id'=>$friend->first_freind_id,'name'=>$user->name];
        }
        foreach ($secondFriends as $friend) {
            $user = User::find($friend->second_freind_id);
            $friendsArray[] =  ['id'=>$friend->second_freind_id,'name'=>$user->name];
        }
        $messagesArray = [];
        foreach($messages as $message){
            $user = User::find($message->sender_id);
            $messagesArray[] =  ['name'=>$user->name,'message'=>$message->content,'senderId'=>$message->sender_id,'id'=>$message->id];
        }
        return response(['group'=>$group,'messages'=>$messagesArray,'friends'=>$friendsArray,'userId'=>Auth::id()],200);
    }
    public function showGroupAndFriends($id)
    {
        $group = group::where('id',$id)->first();
        $group->users;
        $secondFriends = friend::where('first_freind_id',Auth::id())->get();
        $firstFriends = friend::where('second_freind_id',Auth::id())->get();
        $friendsArray = [];
        foreach ($firstFriends as $friend) {
            $user = User::find($friend->first_freind_id);
            $friendsArray[] =  ['id'=>$friend->first_freind_id,'name'=>$user->name];
        }
        foreach ($secondFriends as $friend) {
            $user = User::find($friend->second_freind_id);
            $friendsArray[] =  ['id'=>$friend->second_freind_id,'name'=>$user->name];
        }
        
        return response(['group'=>$group,'friends'=>$friendsArray,'userId'=>Auth::id()],200);
    }
    
    public function update(Request $request, $id)
    {
        $group = group::find($id);
        
        $userArray = [];
        if(!is_null($request->users)){
            foreach($request->users as $user){
                $userArray[] = $user;
            }
        }
        $userArray[] = strval(Auth::id());
        $group->users()->sync($userArray);
        return response([
            'success' => true
        ],200);
    }

    public function updateGroupInfo(Request $request, $id)
    {
        
        
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $group = group::find($id);
        $group->update([
            'group_name'=>$request->name,
            'description'=>$request->description
        ]);
        $userArray = [];
        if(!is_null($request->users)){
            foreach($request->users as $user){
                $userArray[] = $user;
            }
        }
        $userArray[] = strval(Auth::id());
        $group->users()->sync($userArray);
        
        return response([
            'success' => true
        ],200);
        
    }

    
    public function destroy($id)
    {
        $group = group::find($id);
        $group->users()->detach();
        
        massage::where('receiver_id',$id)->where('receiver_type',2)->get()->each(function ($message, $key) {
            $message->delete();
        });

        $group->delete();

        
        
        return response([
            'success' => true
        ],200);

    }
}
