<?php

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class OauthAccessToken extends Model
{

    protected $guarded = [];

    public $timestamps = false;

    protected $table = 'oauth_access_token';
}
