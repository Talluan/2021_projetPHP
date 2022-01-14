<?php

namespace wish\controleur;

use wish\models\Item;
use wish\models\Liste;
use wish\vues\VueConnexion;
use wish\vues\VueListe;
use wish\vues\VueListes;
use wish\vues\VueMesListes;
use wish\vues\VueCreerListe;
use wish\vues\VueDateExpiration;
use wish\models\User;

class ControleurListe {

    
    /**
     * retourne les items de la liste
     */
    function getAllItems($rq, $rs,$args){
        $num = $args['id'];
        $_SESSION['id_liste'] = $args['id'];
        if (Authentication::isConnected()) {
            $users = User::all();
            foreach ($users as $user) {
                $attributUser = $user->getAttributes();
                if ($attributUser['id'] ==  $_SESSION['user']['id']) {   
                    if($attributUser['roleid'] >= 3 ){
                        $etat = "Admin";

                        $l = Liste::find($num);
                        $vueListe = new VueListe($l,$rq,$etat);
                    $rs->getBody()->write($vueListe->render());
                    } else {
                        if($num>10000){
                            $liste = Liste::all();
                foreach ($liste as $list) {
                $attributListe = $list->getAttributes();
                $l = Liste::find($attributListe['no']);
                $temp = "/projetphp/liste/";
                 if ($temp.$attributListe['tokenEdition'] ==  $_SERVER[ 'REQUEST_URI' ]){
                    $test = "Edition";
                    $vueListe = new VueListe($l,$rq,$test);
                    $rs->getBody()->write($vueListe->render());
                 }
                 if ($temp.$attributListe['tokenPartage'] ==  $_SERVER[ 'REQUEST_URI' ]){
                    $test = "VuePartage";
                    $vueListe = new VueListe($l,$rq,$test);
                    $rs->getBody()->write($vueListe->render());
                }
                if ($temp.$attributListe['tokenSurprise'] ==  $_SERVER[ 'REQUEST_URI' ]){
                    $test = "Surprise";
                    $vueListe = new VueListe($l,$rq,$test);
                    $rs->getBody()->write($vueListe->render());
                }

                }
                        } else {
                            $l = Liste::find($num);
                            $vueListe = new VueListe($l,$rq,"Interdit");
                    $rs->getBody()->write($vueListe->render());
                        }
                        
                    }   

                    $proprio = false;
                    if(isset($_SESSION['user']['id'])){
                        $l = Liste::find($num);
                        if($_SESSION['user']['id'] == $l->getAttributes()['user_id']){
                            $proprio = true;
                        }         
                    }
                    if ($proprio){
                        $test = "Proprio";
                        $vueListe = new VueListe($l,$rq,$test);
                        $rs->getBody()->write($vueListe->render());
                    }
            }    
        }   
    }
    
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
            } else {
                //cas ou pas de connexion et pas de cookie
                $vueListes = new VueConnexion($rq);
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
        $liste->tokenEdition = random_int(10000,intval(9999999999));
        $liste->tokenPartage = random_int(10000,intval(9999999999));
        $liste->tokenSurprise = random_int(10000,intval(9999999999));
        if(Authentication::isConnected()){
            $liste->user_id = $_SESSION['user']['id'];
        } else {
            {
                //création d'un cookie durant 1mois (qui permet de stocker les lists mêmes si l'utilisateur n'est pas connecter)
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

    function ajouterDateExpiration($rq,$rs,$args){
        if($rq->isPost()){
            if(!Authentication::isConnected()) return;
            $num = $_SESSION['id_liste'];
            $l = Liste::find($num);
            $parsed = $rq->getParsedBody();
            $date = filter_var($parsed['date'], FILTER_SANITIZE_STRING);

            if($l->user_id == $_SESSION['user']['id']){
                $l->expiration = $date;
                $l->save();
            }
            echo $date;
        }else{
            $vueDate = new VueDateExpiration($rq,$rq);
            $rs->getBody()->write($vueDate->render());
            return $rs;
        }
    }
}