<?php

namespace App\Http\Controllers\Newfront;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        if( $user->userChat ) {
            $messages = $user->userChat->chatMessages()->get();
            $mess = $messages->map(function($item, $k) use ( $user ) {
                $item->avatar = optional($item->from->avatar)->thumbnail;
                //if( !$item->avatar ) $item->avatar = asset('storage/icons/no-image.png');

                unset($item->from);
                if( $item->from_id != $user->id ) {
                    unset($item->from_id);
                }
                return $item;
            });

            return Response::json( $mess );
        }
        return null;
    }

    public function ajaxRequest()
    {
        //return view('ajaxRequest');
    }

    public function ajaxRequestPost(Request $request)
    {
        if( !$request->input('email') ) {
            $request->merge(['email' => session('email')]);
        }
        if( auth()->user() ) {
            $data = $request->validate([
                'message' => 'required',
                'email' => 'nullable',
                'name' => 'nullable'
            ]);
        } else {
            $data = $request->validate([
                'message' => 'required',
                'email' => 'required|email',
                'name' => 'nullable'
            ]);
        }

        $user = auth()->user();
        if( !$user ) {

            session()->put('email', $data['email']);

            $chat = Chat::firstOrCreate([
                'chat_name' => session('_token'),
                'email' => $data['email']
            ]);

            if(  $data['name'] ) {
                $chat->name = $data['name'];
                $chat->save();
            }

            $message = $chat->chatMessages()->create([
                'message' => $data['message']
            ]);
        } else {
            $chat = Chat::firstOrCreate([
                'user_id' => $user->id
            ]);

            $message = $chat->chatMessages()->create([
                'from_id' => $user->id,
                'message' => $data['message']
            ]);

            $message->avatar = optional($user->avatar)->thumbnail;
            //if( !$message->avatar ) $message->avatar = asset('storage/icons/no-image.png');
        }

        return Response::json($message);
    }

    public function ajaxOperatorRequestPost(Request $request)
    {
        $data = $request->validate([
            'message' => 'required'
        ]);
        $user = User::find(auth()->id());

        $chat = Chat::find($request->chat_id);

        $message = $chat->chatMessages()->create([
            'from_id' => $user->id,
            'message' => $data['message']
        ]);

        $message->avatar = optional($user->avatar)->thumbnail;
        //if( !$message->avatar ) $message->avatar = asset('storage/icons/no-image.png');

        return Response::json($message);
    }

    public function ajaxOperatorRequestView(Request $request)
    {
        $userChat = Chat::find($request->id);

        if( $userChat ) {
            $messages = $userChat->chatMessages()->get();
            $mess = $messages->map(function($item, $k) use ( $userChat ) {
                $item->read = 1;
                $item->save();

                if( $item->from ) {
                    $item->avatar = optional($item->from->avatar)->thumbnail;
                }

                //if( !$item->avatar ) $item->avatar = asset('storage/icons/no-image.png');

                unset($item->from);
                if( $userChat->user ) {
                    if( $item->from_id != $userChat->user->id ) {
                        unset($item->from_id);
                    }
                }

                return $item;
            });

            return Response::json( [ $mess, $userChat ] );
        }
        return null;
    }

    public function chat_init()
    {
        if( !Auth::check() ) {
            if( ! session('email') ) {
                return 0;
            }
            $chat = Chat::where('chat_name', session('_token'))->where('email', session('email'))->first();
            return $chat->chatMessages()->get()->toJson();
        }
    }

    // public function create_anonym_chat()
    // {
    //     $chat = Chat::create([
    //         'chat_name' => session('_token')
    //     ]);

    //     dd($chat);
    // }
}
