<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Video;
use App\Models\Article;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $guarded = [];

    static public function validate($request){
        $result = '';
        $data = $request->post();
        if (!count(User::query()->select()->where('id', $request->post('user_id'))->get())) {
            $result = 'invalid user_id';
        }
        if (!(array_key_exists('comment', $data)) || strlen($data['comment']) > 255 ) {
            $result = 'invalid comment';
        }
        if (!array_key_exists('target_model', $data)) {
            switch (($data['target_model'])){
                case'Article':
                    if (count(Article::find($data['target_model']??0))) {
                        $result = 'cannot find article';
                    }
                    break;
                case 'Video':
                    if (count(Video::find($data['target_model']??0))) {
                        $result = 'cannot find article';
                    }
                    break;
                default:
                    $result = 'invalid target model';
            }
        }
        return $result;
    }
}
