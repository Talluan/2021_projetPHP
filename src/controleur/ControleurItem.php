<?php

namespace wish\controleur;

use wish\models\Item;

class ControleurItem{
    
    public static function getItem($id_item) {
        $item =  Item::find($id_item);

    }

    
}