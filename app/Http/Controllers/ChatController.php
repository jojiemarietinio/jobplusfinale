<?php

namespace App\Http\Controllers;

use App\Chat;
use App\ChatMessage;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Redirect;
use View;
use Illuminate\Support\Facades\Input;
use App\Like;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ChatController extends Controller
{

  public function getDashboard()
  {
    $userid = Auth::user()->id;
    $posts = Chat::orderBy('created_at', 'desc')->get();
    $chats = Chat::where('user_id',$userid)->get();
    $users = User::orderBy('id', 'desc')->get();

    return view('Dashboard', ['posts' => $posts], ['users' => $users]);

  }

  public function postCreatePost(Request $request)
  {
    $userid = Auth::user()->id;
    $this->validate($request,
      [
        'body' => 'required|max:1000'
      ]);
    $post = new Chat();
    $post->body = $request['body'];
    $message = 'There was an error';
    if ($request->user()->chats()->save($post)){
      $message= 'Mesage send successfully';
    }
    return redirect()->route('emp/messages')->with(['message' => $message]);

  }



  // public function sendMessage()
  // {
  //   $username = Input::get('username');
  //   $text = Input::get('text');

  //   $chatMessage = new ChatMessage();
  //   $chatMessage->sender_username = $username;
  //   $chatMessage->message = $text;
  //   $chatMessage->save();

  // }

  // public function isTyping()
  // {
  //   $username = Input::get('username');

  //   $chat = Chat::find(1);
  //   if($chat->user1 == $username) {
  //     $chat->user1_is_typing = true;
  //   } else {
  //     $chat->user2_is_typing = true;
  //   }

  //   $chat->save();

  // }

  // public function notTyping()
  // {
  //   $username = Input::get('username');

  //   $chat = Chat::find(1);
  //   if($chat->user1 == $username) {
  //     $chat->user1_is_typing = false;
  //   } else {
  //     $chat->user2_is_typing = false;
  //   }

  //   $chat->save();

  // }

  // public function retrieveChatMessages()
  // {
  //   $username = Input::get('username');

  //   $message = ChatMessage::where('sender_username', '!=', $username)->where('read', '=', false)->first();

  //   if(count($message) > 0)
  //   {
  //     $message->read = true;
  //     $message->save();

  //     return $message->message;
  //   }
  // }

  // public function retrieveTypingStatus()
  // {
  //   $username = Input::get('username');

  //   $chat = Chat::find(1);

  //   if($chat->user1 == $username) {
  //     if($chat->user2_is_typing) {
  //       return $chat->user2;
  //     }
  //   } else {
  //     if($chat->user1_is_typing) {
  //       return $chat->user1;
  //     }
  //   }

  //  }


}

?>