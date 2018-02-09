<?php

namespace App\Http\Controllers\Discuss;

use App\Article;
use App\Events\MessageCreatedEvent;
use App\Events\MessageDeletedEvent;
use App\RoomMessage;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('api');

        $this->middleware('auth:api')->only(['putMessage', 'postMessage']);
    }

    public function getRooms()
    {
        $articles = Article::select('id', 'slug', 'author_id', 'image', 'views')
            ->whereHas('contents', function($q) {
                $q->where('language_id', 2)->published();
            })
            ->with(['contents' => function($q) {
            $q->select('article_id', 'title')->where('language_id', 2); /*This must be refactored*/
        }])->paginate(10);

        return response()->json($articles, 200);
    }

    public function getMessages($article_slug)
    {
        $article_messages = Article::slug($article_slug)->withRoomAndMessages()->with(['contents' => function($q){
            $q->where('language_id', 2)->select('article_id', 'sub_title', 'title', 'language_id');
        }])->first();

        $previous_user = null;
        $index = -1;

        $mapped_messages = $article_messages->room->messages->reduce( function ($carry, $message) use(&$previous_user, &$index) {

            if($previous_user != $message->user_id){
                $previous_user = $message->user_id;
                $index++;
            }

            $carry[$index][] = $message;

            return $carry;
        }, []);

        $article_messages = $article_messages->toArray();

        $article_messages['room']['messages'] = $mapped_messages;

        return response()->json($article_messages, 200);
    }

    public function putMessage($article_slug)
    {
        request()->validate([
           'message' => 'required'
        ]);

        $article = Article::slug($article_slug)->with('room')->first();

        $message = $article->room->messages()->create([
            'room_id' => $article->room->id,
            'user_id' => auth()->user()->user_id,
            'message' => request()->input('message')
        ]);

        event(new MessageCreatedEvent($message));

        return response()->json([
            'header' => 'Successful',
            'message' => 'Message is successfully received',
            'state' => 'success'
        ], 200);
    }

    public function postMessage($message_id)
    {
        request()->validate([
            'message' => 'required'
        ]);

        $message = RoomMessage::userMessage($message_id, auth()->user()->user_id)->firstOrFail();

        $message->message = request()->input('message');

        $message->save();

        return response()->json([
            'header' => 'Successful',
            'message' => 'Message is successfully updated',
            'state' => 'success'
        ], 200);
    }

    public function deleteMessage($message_id)
    {
        $message = RoomMessage::userMessage($message_id, auth()->user()->user_id)
                                ->with(['room' => function($q) { $q->with('article');}])
                                ->firstOrFail();

        event(new MessageDeletedEvent($message->id, $message->room->article->slug));

        $message->forceDelete();

        return response()->json([
            'header' => 'Successful',
            'message' => 'Message is successfully deleted',
            'state' => 'success'
        ], 200);
    }
}
