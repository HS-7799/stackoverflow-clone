<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReplyResource;
use App\Notifications\NewReplyNotification;
use App\Reply;
use App\Question;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReplyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth.jwt')->except(['index','show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Question $question)
    {
        return ReplyResource::collection($question->replies);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question,Request $request)
    {
        request()->validate([
            'body' => 'required'
        ]);

        $reply = new Reply();
        $reply->body = request('body');
        $reply->question_id = $question->id;
        $reply->user_id = auth()->user()->id;
        $reply->save();

        $user = $question->user;

        $user->notify(new NewReplyNotification($reply));

        return response(new ReplyResource($reply),Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question,Reply $reply)
    {
        return new ReplyResource($question->replies()->findOrFail($reply->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Question $question, Reply $reply)
    {
        $reply->update(request()->validate([
            'body' => 'required'
        ]));

        return response('updated',Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question,Reply $reply)
    {
        $reply->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
