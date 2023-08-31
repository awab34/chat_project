<?php

namespace App\Http\Controllers;

use App\Models\friend;
use App\Models\massage;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;
use App\Models\friend_request;

class FriendController extends Controller
{
    public function index()
    {
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
        /*$freindRequests = friend_request::where('receiver_id',Auth::id())->where('status',0)->get();
        $requestsArray = [];
        
        foreach ($freindRequests as $request) {
            $user = User::find($request->sender_id);
            $requestsArray[] =  ['id'=>$request->id,'name'=>$user->name,'requester'=>$request->sender_id];
        }*/

        return response([
            'friends' => $friendsArray
          ],200);
    }

    public function create()
    {
        return view('friend.create');
    }
    public function search(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);
        $users = User::where('name', 'like','%'.$request->name.'%')->get();
        $secondFriends = friend::where('first_freind_id',Auth::id())->get();
        $firstFriends = friend::where('second_freind_id',Auth::id())->get();
        $requesters = friend_request::where('receiver_id',Auth::id())->get();
        $anwserers = friend_request::where('sender_id',Auth::id())->get();
        $usersArray = [];
        foreach ($users as $user) {
            if($user->id == Auth::id()){
                
            }else{
                $allowed = true;
                foreach ($secondFriends as $friend) {
                    if($user->id == $friend->second_freind_id){
                        $allowed = false;
                    }
                }
                foreach ($firstFriends as $friend) {
                    if($user->id == $friend->first_freind_id){
                        $allowed = false;
                    }
                }
                foreach ($requesters as $friend) {
                    if($user->id == $friend->sender_id){
                        $allowed = false;
                    }
                }
                foreach ($anwserers as $friend) {
                    if($user->id == $friend->receiver_id){
                        $allowed = false;
                    }
                }
                if($allowed){
                    $usersArray[] = ['id'=>$user->id,'name'=>$user->name];
                }
                
            }
          }
          
          return response([
            'searchResult' => $usersArray,
            'searchStatus'=>true
          ],200);
    }

    public function store(Request $request)
    {
        echo "hi awab";
        $request->validate([
            'first_freind' => 'required|string',
            'status' => 'required',
            'requestId' => 'required',
        ]);
        echo $request->requestId;
        if(strcmp("1",$request->status)==0){
            $freindRequest = friend_request::find($request->requestId);
            $freindRequest->status = $request->status;
            $freindRequest->save();
            $friend = friend::create([
                'first_freind_id'=>$request->first_freind,
                'second_freind_id'=>Auth::id(),
                'status'=>0
            ]);
        }else{
            $freindRequest = friend_request::find($request->requestId);
            $freindRequest->status = $request->status;
            $freindRequest->save();
        }
        return response([
            'success' => true
        ],200);
    }

    public function destroy($id)
    {
        $secondFriend = friend::where('first_freind_id',Auth::id())->where('second_freind_id',$id)->first();
        $firstFriend = friend::where('second_freind_id',Auth::id())->where('first_freind_id',$id)->first();
        $requester = friend_request::where('receiver_id',Auth::id())->where('sender_id',$id)->first();
        $anwserer = friend_request::where('sender_id',Auth::id())->where('receiver_id',$id)->first();
        
if(!is_null($secondFriend)){
    
        $secondFriend->delete();
    
}
if(!is_null($firstFriend)){
    
        $firstFriend->delete();
    
}
if(!is_null($requester)){
    
        $requester->delete();
    
}

if(!is_null($anwserer)){
    
        $anwserer->delete();
    
}
        
        
        
return response([
    'success' => true
],200);
    }
    public function showChatWithFreind($id)
    {
        $messages = massage::where('sender_id',Auth::id())->where('receiver_id',$id)->where('receiver_type',1)->orWhere(function (Builder $query) use ($id) {
            $query->where('receiver_id',Auth::id())
                  ->where('sender_id',$id)
                  ->where('receiver_type',1);
        })->get();
        $messagesArray = [];
        foreach($messages as $message){
            $user = User::find($message->sender_id);
            $messagesArray[] =  ['name'=>$user->name,'message'=>$message->content,'senderId'=>$message->sender_id,'id'=>$message->id];
        }
        $friendInfo = User::find($id);
       return response([
        'messages' => $messagesArray,
        'userId'=>Auth::id(),
        'friendInfo'=>$friendInfo,
        ],200);
    }
    public function showFriendInfo($id)
    {
        $friendInfo = User::find($id);
        return response([
        'friendInfo'=>$friendInfo,
        ],200);
    }
    public function storeFreindMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'reciever'=>'required'
        ]);
        $message = massage::create([
            'content'=>$request->message,
            'sender_id'=>Auth::id(),
            'receiver_id'=>$request->reciever,
            'receiver_type'=>1,
        ]);

        return response([
            'success' => true
        ],200);
    }
}
