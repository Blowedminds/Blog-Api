<?php

namespace App\Http\Controllers\Discuss;

use App\Article;
use App\Events\NewMessageEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('api');

        $this->middleware('auth:api')->only(['putMessage']);
    }

    public function getRooms()
    {
        $articles = Article::select('id', 'slug', 'author_id', 'image', 'views')->paginate(10);

        return response()->json($articles, 200);
    }

    public function getMessages($article_slug)
    {
        $article = Article::slug($article_slug)->withRoomAndMessages()->first();

        return response()->json($article, 200);
    }

    public function putMessage($article_slug)
    {
        $article = Article::slug($article_slug)->with('room')->first();

        $message = $article->room->messages()->create([
            'room_id' => $article->room->id,
            'user_id' => auth()->user()->user_id,
            'message' => request()->input('message')
        ]);

        event(new NewMessageEvent($message));

        return response()->json([
            'header' => 'Successful',
            'message' => 'Message is successfully received',
            'state' => 'success'
        ], 200);
    }
}
