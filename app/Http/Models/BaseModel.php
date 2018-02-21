<?php

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $guarded = [];

    public static function checkUnique($param, $field, $model_param = '')
    {
        $query = self::query();
        $query->where($field, $param);

        if ($query->count() > 0) {
            if ($model_param == $param) {
                return true;
            }
            return false;
        }

        return true;
    }
}