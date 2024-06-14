<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Comment;
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : JsonResponse
    {
        $articles = Article::all();
        return response()->json($articles);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : JsonResponse
    {
        if ($validation_errors = Article::validate($request)) {
            $response = $validation_errors;
        } else {
            Article::create($request->post());
            $response = 'ok';
        }
        return response()->json(['response' => $response]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) : JsonResponse
    {
        if ($article = Article::find($id)) {
            $response = $article;
        } else {
            $response = ['response' => 'missed item'];
        }
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) : JsonResponse
    {
        if ($validation_errors = Article::validate($request)) {
            $response = $validation_errors;
        } else if ($article = Article::find($id)) {
            $article->update($request->post());
            $response = 'ok';
        } else {
            $response = 'missed item';
        }
        return response()->json(['response' => $response]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : JsonResponse
    {
        if ($article = Article::find($id)) {
            Comment::query()->select()->where('target_model', 'articles')->where('target_id', $id)->delete();
            $article->delete($id);
            $response = 'ok';
        } else {
            $response = 'missed item';
        }
        return response()->json(['response' => $response]);
    }
}
