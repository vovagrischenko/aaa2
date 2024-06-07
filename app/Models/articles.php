<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\users;

class articles extends Model
{
    use HasFactory;
    protected $table = 'article';
    protected $guarded = [];

    static public function validate($request){
        $data = $request->post();
        $user = users::query()->select()->where('id', $request->post('user_id'))->get();
        if (!count($user)) {
            return 'invalid user_id';
        }
        if (!(array_key_exists('name', $data))) {
            return 'invalid name';
        }
        if (!(array_key_exists('article', $data))) {
            return 'invalid article';
        }
        return '';
    }
}