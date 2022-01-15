<?php

namespace wish\models;

class Reservation extends \Illuminate\Database\Eloquent\Model
{
    protected $table = "reservation";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function item() {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
