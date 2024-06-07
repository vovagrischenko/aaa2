<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\users;
use App\Models\articles;
use App\Models\comments;
use App\Models\videos;

class ApiController extends Controller

{
    public function getModel($model){
        $class = "";
        $path = sprintf('App\Models\%s',$model);
        if (class_exists($path)){
            $class = $path;
        }

        return $class;
    }

    public function index(Request $request, $model) {

        $user = users::query()->select()->where('id', 1)->get();

        if(!$model = self::getModel($model)){
            return response()->json(['response' => 'invalid model']);
        };
        $owner = $request->get('owner');
        $limit = $request->get('limit');
        $page = $request->get('page');
        $items = $model::all();
        if ($limit) {
            $items = $items->chunk($page??1);
        }
        return response()->json($items);
    }

    public function add(Request $request, $model) {
        if(!$model = self::getModel($model)){
            return response()->json(['response' => 'invalid model']);
        };
        if ($Validation_errors = $model::validate($request)) {
            $response = $Validation_errors;
        } else if ($model == "App\Models\users"){
            if (count(($model::query()->select()->where('email',$request->post('email'))->get()))) {
                $response = 'item already exists!';
            }
        }
        else {
            $model::create($request->post());
            $response = 'ok';
        }
        return response()->json(['response' => $response]);
    }

    public function get(Request $request, $model, $id) {
        if(!$model = self::getModel($model)){
            return response()->json(['response' => 'invalid model']);
        };
        if ($item = $model::find($id)) {
            $response = $user;
        } else {
            $response = ['response' => 'missed item'];
        }
        return response()->json($response);

    }

    public function update(Request $request, $model, $id) {
        if(!$model = self::getModel($model)){
            return response()->json(['response' => 'invalid model']);
        };
        if ($Validation_errors = $model::validate($request)) {
            $response = $Validation_errors;
        } else if ($item = $model::find($id)) {
            $item->update($request->post());
            $response = 'ok';
        } else {
            $response = ['response' => 'missed item'];
        }
        return response()->json(['response' => $response]);

    }

    public function delete(Request $request, $model, $id) {
        if(!$model = self::getModel($model)){
            return response()->json(['response' => 'invalid model']);
        };
        if ($item = $model::find($id)) {
            $item->delete($id);
            $response = 'ok';
        } else {
            $response = ['response' => 'missed item'];
        }
        return response()->json(['response' => $response]);
    }
}
