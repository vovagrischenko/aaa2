<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : JsonResponse
    {
        $items = User::all();
        $limit = $request->get('limit');
        $page = $request->get('page');
        if ($limit) {
            $items = $items->chunk($page??1);
        }
        return response()->json($items);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : JsonResponse
    {
        if ($Validation_errors = User::validate($request)) {
            $response = $Validation_errors;
        } elseif (count((User::query()->select()->where('email',$request->post('email'))->get()))) {
            $response = 'item already exists!';
        } else {
            User::create($request->post());
            $response = 'ok';
        }
        return response()->json(['response' => $response]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) : JsonResponse
    {
        if ($item = User::find($id)) {
            $response = $item;
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
        if ($Validation_errors = User::validate($request)) {
            $response = $Validation_errors;
        } else if ($item = User::find($id)) {
            $item->update($request->post());
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
        if ($item = User::find($id)) {
            $item->delete($id);
            $response = 'ok';
        } else {
            $response = ['response' => 'missed item'];
        }
        return response()->json(['response' => $response]);
    }
}
