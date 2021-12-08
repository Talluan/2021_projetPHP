<?php

namespace wish\controleur;

use wish\models\Liste;
use wish\vues\VueListe;
use wish\vues\VueListes;

class ControleurListe {

    
    /**
     * retourne les items de la liste
     * @param $num numéro de la liste dont on veut les items
     */
    function getAllItems($rq, $rs,$num){
        $l = Liste::find($num);
        
        $vueListe = new VueListe($l);
        $rs->getBody()->write($vueListe->render());
        return $rs;
    }

    /**
     * retourne toutes les listes
     */
    function getAllListes($rq,$rs) {
        $listes = Liste::all();
        $vueListes = new VueListes($listes);
        $rs->getBody()->write($vueListes->render());
        return $rs;
    }

}