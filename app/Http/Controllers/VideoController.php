<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Video;
use function Laravel\Prompts\select;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : JsonResponse
    {
        $videos = Video::all();
        return response()->json($videos);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : JsonResponse
    {
        if ($Validation_errors = Video::validate($request)) {
            $response = $Validation_errors;
        } else {
            Video::create($request->post());
            $response = 'ok';
        }
        return response()->json(['response' => $response]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) : JsonResponse
    {
        if ($video = Video::find($id)) {
            $response = $video;
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
        if ($validation_errors = Video::validate($request)) {
            $response = $validation_errors;
        } else if ($video = Video::find($id)) {
            $video->update($request->post());
            $response = 'ok';
        } else {
            $response =  'missed item';
        }
        return response()->json(['response' => $response]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : JsonResponse
    {
        if ($video = Video::find($id)) {
            Comment::query()->select()->where('target_model', 'videos')->where('target_id', $id)->delete();
            $video->delete($id);
            $response = 'ok';
        } else {
            $response = 'missed item';
        }
        return response()->json(['response' => $response]);
    }
}
