<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Question;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuestionController extends Controller
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
    public function index()
    {

        return QuestionResource::collection(Question::latest()->paginate(3));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $question = auth()->user()->questions()->create(request()->validate([
            'title' => 'required|string|max:255',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id'
        ]));

        return response(new QuestionResource($question),Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        return new QuestionResource($question);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        request()->validate([
            'title' => 'required|string|max:255',
            'body' => 'required',
            // 'category_id' => 'required|exists:categories,id'

        ]);
        $question->update($request->all());
        return response('updated',Response::HTTP_ACCEPTED);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return response(null,Response::HTTP_NO_CONTENT);

    }
}
