<?php

namespace wish\models;

class Role extends \Illuminate\Database\Eloquent\Model
{
    protected $table = "role";
    protected $primaryKey = "roleid";
    public $timestamps = false;

    public function user() {
        return $this->hasMany('wish\models\User', 'roleid');
    }

}
