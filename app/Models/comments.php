<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\users;

class comments extends Model
{
    use HasFactory;
    protected $table = 'comment';
    protected $guarded = [];

    static public function validate($request){
        $data = $request->post();
        $user = users::query()->select()->where('id', $request->post('user_id'))->get();
        if (!count($user)) {
            return 'invalid user_id';
        }
        if (!(array_key_exists('comment', $data)) || strlen($data['comment']) > 255 ) {
            return 'invalid comment';
        }
        return '';
    }
}
