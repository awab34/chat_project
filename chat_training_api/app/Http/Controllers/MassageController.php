<?php

namespace App\Http\Controllers;

use App\Models\massage;
use Illuminate\Http\Request;
use Auth;


class MassageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'required',
        ]);

        $group = massage::create([
            'content'=>$request->message,
            'sender_id'=>Auth::id(),
            'receiver_id'=>$request->receiver_id,
            'receiver_type'=>2
        ]);
        return response([
            'success' => true
        ],200);

    }

    public function destroy($id)
    {
        $massage = massage::find($id);
        $massage->delete();
        return response([
            'success' => true
        ],200);
    }
}
