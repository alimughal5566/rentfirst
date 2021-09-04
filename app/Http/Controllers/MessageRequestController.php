<?php

namespace App\Http\Controllers;

use App\Models\MessageRequest;
use Illuminate\Http\Request;

class MessageRequestController extends Controller
{
    //
    public function create(Request $request){
//            $data=json_decode($request);
        $data=json_decode($request->post);
//            dd($data);
        $mesg= new MessageRequest();

        $mesg->user_id=$request->user_id;
        $mesg->post_id=$data->id;
        $mesg->add_owner=$data->user_id;
        $mesg->start_date=$request->start_date;
        $mesg->end_date=$request->end_date;
        $mesg->status=0;
        $mesg->save();

        return redirect()->back();
    }

    public function index(){
        $mesg=MessageRequest::where('status',0)->where('add_owner',auth()->id())->get();
//        dd($mesg);
        $pagePath = 'message-request';
        return view('account.messenger.message-request',compact('pagePath'));
    }

    public function messageApprove(Request $request){
        $user_id=$request->user_id;
//            dd($user_id);
        $mesg=MessageRequest::where('user_id',$user_id)->get()->first();
        $mesg->status=1;
        $mesg->save();
        return redirect()->back();
    }

    public function messageDecline(Request $request){
        $id=$request->id;
        $mesg=MessageRequest::find($id);
        $mesg->delete();
        return redirect()->back();
    }
}
