<?php

namespace wish\controleur;

use wish\models\Liste;
use wish\vues\VueListe;

class ControleurListe {

    
    /**
     * retourne les items de la liste
     * @param $num numÃ©ro de la liste dont on veut les items
     */
    function getAllItems($rq, $rs,$num){
        $l = Liste::find($num);
        
        $vueListe = new VueListe($l);
        $rs->getBody()->write($vueListe->render());
        return $rs;
    }

}