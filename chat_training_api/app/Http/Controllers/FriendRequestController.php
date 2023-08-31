<?php

namespace App\Http\Controllers;

use App\Models\friend_request;
use Illuminate\Http\Request;
use Auth;
use App\Models\User; 

class FriendRequestController extends Controller
{
    public function store($id)
    {
        $freind_request = friend_request::create([
            'sender_id'=>Auth::id(),
            'receiver_id'=>$id,
            'status'=>0
        ]);
        return response([
            'success' => true
        ],200);
    }
    public function show_request(){
        $freindRequests = friend_request::where('receiver_id',Auth::id())->where('status',0)->get();
        $requestsArray = [];
        
        foreach ($freindRequests as $request) {
            $user = User::find($request->sender_id);
            $requestsArray[] =  ['id'=>$request->id,'name'=>$user->name,'requester'=>$request->sender_id];
        }
        return response([
            'friendRequests' => $requestsArray
          ],200);
    }
}
