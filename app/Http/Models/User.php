<?php

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $guarded = [];

    protected $primaryKey = 'uid';


    public function getSaltPassword($password)
    {
        return md5($password . md5($this->login_salt));
    }

    public function verifyPassword($password)
    {
        return $this->getSaltPassword($password) == $this->login_pwd;
    }

    public function setSalt($length = 16)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ~!@#$%^&*()_+';
        $salt = '';
        for ($i = 0; $i < $length; $i++) {
            $salt .= $chars[mt_rand(0, strlen($chars) - 1)];
        }

        $this->login_salt = $salt;
    }

    public function setPassWord($password)
    {
        $this->login_pwd = $this->getSaltPassword($password);
    }

}
