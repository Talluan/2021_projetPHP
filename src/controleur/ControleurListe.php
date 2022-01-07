<?php

namespace wish\controleur;

use wish\models\Item;
use wish\models\Liste;
use wish\vues\VueListe;
use wish\vues\VueListes;
use wish\vues\VueMesListes;
use wish\vues\VueCreerListe;

class ControleurListe {

    
    /**
     * retourne les items de la liste
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
     * retourne toutes les listes publiques
     */
    function getAllListes($rq, $rs, $args) {
        $listes = Liste::all();
        $items = Item::all();
        $vueListes = new VueListes($listes,$rq,$items);
        $rs->getBody()->write($vueListes->render());
        return $rs;
    }

    /**
     * retourne toutes les listes de l'utilisateur (seulement si connecté pour l'instant)
     */
    function getAllMyListes($rq, $rs, $args) {
        if (Authentication::isconnected()){
          $listes = Liste::all();
          $items = Item::all();
          $vueMesListes = new VueMesListes($listes,$rq,$items,$_SESSION['user']['id']);
          $rs->getBody()->write($vueMesListes->render());
         return $rs;
        } else { 
            if(isset($_COOKIE['WishListe2021AuChocolat'])){
                $track_user_code = $_COOKIE[ 'WishListe2021AuChocolat' ];
                $listes = Liste::all();
                $items = Item::all();
                $vueListes = new VueMesListes($listes,$rq,$items,$track_user_code);
                $rs->getBody()->write($vueListes->render());
                return $rs;
                } 
            }
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
        if(Authentication::isConnected()){
            $liste->user_id = $_SESSION['user']['id'];
        } else {
            {
                $nomCookie = 'WishListe2021AuChocolat';
                $valCookie = random_int(intval(-99999999999),-2);
                setcookie($nomCookie, $valCookie, time() + 60*60*24*30);
                $liste->cookieUser = $valCookie;
            }
        }
        $liste->save();
        $path = $rq->getUri()->getBasePath();
        $rs = $rs->withRedirect($path);
        return $rs;
    }

    /**
     * méthode qui retourne l'affichage de la création des listes
     * @param rq objet requête
     * @param rs objet de retour contenant la vue 
     */
    function creationListe($rq, $rs, $args) {
        $vueCreer = new VueCreerListe($rq, $rq);
        $rs->getBody()->write($vueCreer->render());
        return $rs;
    }
}