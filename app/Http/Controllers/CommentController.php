<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Comment;
class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : JsonResponse
    {
        $comments = Comment::all();
        return response()->json($comments);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : JsonResponse
    {
        if ($Validation_errors = Comment::validate($request)) {
            $response = $Validation_errors;
        } else {
            Comment::create($request->post());
            $response = 'ok';
        }
        return response()->json(['response' => $response]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) : JsonResponse
    {
        if ($comment = Comment::find($id)) {
            $response = $comment;
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
        if ($Validation_errors = Comment::validate($request)) {
            $response = $Validation_errors;
        } else if ($comment = Comment::find($id)) {
            $comment->update($request->post());
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
        if ($comment = Comment::find($id)) {
            $comment->delete($id);
            $response = 'ok';
        } else {
            $response = ['response' => 'missed item'];
        }
        return response()->json(['response' => $response]);
    }
}
