<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Article;
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
        if ($Validation_errors = Article::validate($request)) {
            $response = $Validation_errors;
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
        if ($Validation_errors = Article::validate($request)) {
            $response = $Validation_errors;
        } else if ($article = Article::find($id)) {
            $article->update($request->post());
            $response = 'ok';
        } else {
            $response = ['response' => 'missed item'];
        }
        return response()->json(['response' => $response]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : JsonResponse
    {
        if ($article = Article::find($id)) {
            $article->delete($id);
            $response = 'ok';
        } else {
            $response = ['response' => 'missed item'];
        }
        return response()->json(['response' => $response]);
    }
}
