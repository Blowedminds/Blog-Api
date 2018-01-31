<?php


namespace App\Observers;


use App\Article;
use App\ArticleRoom;

class ArticleObserver
{
    public function created(Article $article)
    {
        $article_room = ArticleRoom::firstOrCreate(['article_id' => $article->id], [
            'article_id' => $article->id,
        ]);
    }
}