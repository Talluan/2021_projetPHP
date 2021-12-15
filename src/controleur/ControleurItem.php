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
        $vueitem = new VueItem($item,$rq);
        $rs->getBody()->write($vueitem->render());
        return $rs;
    }

    public function ajouterItem($rq,$rs,$args) {
        if(!isset($_SESSION['id_liste'])){
            $rs->getBody()->write("Vous n'avez pas acces a cette page");
            return $rs;
        }
        $item = new Item();
        $item->liste_id = $_SESSION['id_liste'];
        $item->nom = $rq->nom;
        $item->descr = $rq->description;
        $item->img = $rq->img;
        $item->url = $rq->url;
        $item->tarif = $rq->tarif;
        $item->save();
    }
    
}