<?php

namespace wish\controleur;

use wish\models\Item;
use wish\vues\VueItem;

class ControleurItem{
    
    /*
    *fonction qui renvoie l'item demande grace a son id dans l'URL
    *@return le code html corespondant a la vue
    */
    public static function getItem($rq,$rs,$args) {
        $id_item = $args['id'];
        $item =  Item::find($id_item);
        $vueitem = new VueItem($item);
        $rs->getBody()->write($vueitem->render());
        return $rs;
    }

    
}