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

    /**
     * crée une nouvelle liste
     * @param rq objet contenant le titre, la description, le user_id et expiration
     * @param rs objet de retour contenant la vue 
     */
    function creerListe($rq, $rs) {
        $liste = new Liste();
        $liste->titre = $rq->titre;
        $liste->description = $rq->description;
        $liste->user_id = $rq->user_id;
        $liste->expiration = $rq->expiration;
        $liste->save();
    }

    /**
     * méthode qui retourne l'affichage de la création des listes
     * @param rq objet requête
     * @param rs objet de retour contenant la vue 
     */
    function creationListe($rq, $rs) {
        $vueCreer = new vueCreerListe();
        $rs->getBody()->write($vueCreer->render());
        return $rs;
    }
}