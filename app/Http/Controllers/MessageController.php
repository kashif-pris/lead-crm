<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use TCG\Voyager\Facades\Voyager;

use App\Models\Message;

class MessageController extends Controller
{
    public function index()
    {
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $messages = Message::with('from','to','event')->where('msg_to',Auth::user()->id)->get();
        return view('messages.record',compact('messages','dataType'));
      
    }

    public function sent()
    {
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $messages = Message::with('from','to','event')->where('msg_from',Auth::user()->id)->get();
        return view('messages.sent',compact('messages','dataType'));
      
    }

    public function show($id)
    {
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        Message::where('id',$id)->update([
                 'status' => 1
        ]);
        $message = Message::with('from','to','event')->where('id',$id)->first();
        return view('messages.view',compact('message','dataType'));
      
    }
}
