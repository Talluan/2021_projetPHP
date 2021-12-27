<?php

namespace wish\models;

class Item extends \Illuminate\Database\Eloquent\Model
{
    protected $table = "item";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function liste() {
        return $this->belongsTo('wish\models\Liste', 'liste_id');
    }

}