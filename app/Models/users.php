<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    use HasFactory;
    protected $table = 'user';
    protected $guarded = [];

    static public function validate($request) {
        $data = $request->post();
        if (!(array_key_exists('email', $data) || filter_var($data['email'], FILTER_VALIDATE_EMAIL))) {
            return 'ivalid email';
        }
        if (!(array_key_exists('password', $data) || strlen($data['password']) == 6)) {
            return 'ivnalid password';
        }
        return "";
    }
}
