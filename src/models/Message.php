<?php

namespace wish\models;

class Message extends \Illuminate\Database\Eloquent\Model
{
    protected $table = "message";
    protected $primaryKey = "message_id";
    public $timestamps = false;

    public function liste() {
        return $this->belongsTo('wish\models\Message', 'liste_id');
    }
}
