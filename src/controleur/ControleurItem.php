<?php

use wish\models\Item;

class ControleurItem{
    
    public function getItem($id_item) : Item{
        return Item::find($id_item);
    }

    
}