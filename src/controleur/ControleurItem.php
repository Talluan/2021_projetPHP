<?php

namespace wish\controleur;

use wish\models\Item;

class ControleurItem{
    
    public static function getItem($id_item) : Item{
        return Item::find($id_item);
    }

    
}