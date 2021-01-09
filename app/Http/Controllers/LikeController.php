<?php

namespace App\Http\Controllers;

use App\Like;
use App\Reply;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LikeController extends Controller
{
    public function like(Reply $reply)
    {
        $reply->likes()->create([
            'user_id' => auth()->id()
        ]);

        return response('liked',Response::HTTP_CREATED);
    }

    public function unlike(Reply $reply)
    {
        $reply->likes()->where('user_id',auth()->id())->first()->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
