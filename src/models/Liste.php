<?php

namespace wish\models;
use \Exception;

class Liste extends \Illuminate\Database\Eloquent\Model
{
    protected $table = "liste";
    protected $primaryKey = "no";
    public $timestamps = false;

    public function items() {
        return $this->hasMany('wish\models\Item', 'liste_id');
    }

}
