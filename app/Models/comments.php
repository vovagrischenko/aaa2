<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\users;
use App\Models\video;
use App\Models\article;

class comments extends Model
{
    use HasFactory;
    protected $table = 'comment';
    protected $guarded = [];

    static public function validate($request){
        $result = '';
        $data = $request->post();
        $user = users::query()->select()->where('id', $request->post('user_id'))->get();
        if (!count($user)) {
            $result = 'invalid user_id';
        }
        if (!(array_key_exists('comment', $data)) || strlen($data['comment']) > 255 ) {
            $result = 'invalid comment';
        }
        if (!array_key_exists('target_model', $data)) {
            try {
                $model = sprintf('App\Models\%s',$data['target_model']);
                $tagret = $model::find($data['target_id']);
                if (!count($target)) {
                    $result = 'cannot find target item';
                }
            } catch(Exception) {
                $result = 'invalid target_model or target_id';
            }
        }

        return $result;
    }
}
