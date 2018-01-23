<?php

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $guarded = [];

    protected $primaryKey = 'uid';

    protected $hidden = [
        'login_pwd'
    ];

    public function getSaltPassword($password)
    {
        return md5($password . md5($this->login_salt));
    }

    public function verifyPassword($password)
    {
        return $this->getSaltPassword($password) == $this->login_pwd;
    }
}
