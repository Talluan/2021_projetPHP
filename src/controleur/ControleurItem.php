<?php

namespace wish\controleur;

use wish\models\Item;
use wish\vues\VueItem;

class ControleurItem{
    
    public static function getItem($rq,$rs,$id_item) {
        $item =  Item::find($id_item);
        $vueitem = new VueItem($item);
        $rs->getBody()->write($vueitem->render());
        return $rs;
    }

    
}