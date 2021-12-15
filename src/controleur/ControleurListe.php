<?php

namespace wish\controleur;

use wish\models\Liste;
use wish\vues\VueListe;
use wish\vues\VueListes;
use wish\vues\VueCreerListe;

class ControleurListe {

    
    /**
     * retourne les items de la liste
     * @param $num numéro de la liste dont on veut les items
     */
    function getAllItems($rq, $rs,$args){
        $num = $args['id'];
        $_SESSION['id_liste'] = $args['id'];
        $l = Liste::find($num);
        
        $vueListe = new VueListe($l,$rq);
        $rs->getBody()->write($vueListe->render());
        return $rs;
    }

    /**
     * retourne toutes les listes
     */
    function getAllListes($rq, $rs, $args) {
        $listes = Liste::all();
        $vueListes = new VueListes($listes,$rq);
        $rs->getBody()->write($vueListes->render());
        return $rs;
    }

    /**
     * crée une nouvelle liste
     * @param rq objet contenant le titre, la description, le user_id et expiration
     * @param rs objet de retour contenant la vue 
     */
    function creerListe($rq, $rs, $args) {
        $parsed = $rq->getParsedBody();
        $nom = filter_var($parsed['nom'], FILTER_SANITIZE_STRING);
        $descr = filter_var($parsed['descr'], FILTER_SANITIZE_STRING);
        $liste = new Liste();
        $liste->titre = $nom;
        $liste->description = $descr;
        $liste->user_id = 1;
        $liste->save();
    }

    /**
     * méthode qui retourne l'affichage de la création des listes
     * @param rq objet requête
     * @param rs objet de retour contenant la vue 
     */
    function creationListe($rq, $rs, $args) {
        $vueCreer = new VueCreerListe($rq,$rq);
        $rs->getBody()->write($vueCreer->render());
        return $rs;
    }
}