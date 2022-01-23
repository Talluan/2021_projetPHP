<?php

namespace wish\controleur;

use wish\models\Item;
use wish\models\Liste;
use wish\models\Reservation;
use wish\vues\VueConnexion;
use wish\vues\VueListe;
use wish\vues\VueListes;
use wish\vues\VueMesListes;
use wish\vues\VueCreerListe;
use wish\vues\VueEditerListe;
use wish\vues\VueDateExpiration;
use wish\models\User;
use wish\vues\VueSupprimerItem;
use wish\vues\VuePartage;

class ControleurListe {

    
    /**
     * retourne les items de la liste
     */
    function getAllItems($rq, $rs,$args){
        $num = $args['id'];
        $_SESSION['id_liste'] = $args['id'];
        $proprio = false;
        $temp = $rq->getUri()->getBasePath()."/liste/";
        if (Authentication::isConnected()) { //si l'utilisateur est connecter
                    if(isset($_SESSION['user']['id'])){
                        $l = Liste::find($num);
                        if($l != null){ 
                            $attributListe = $l->getAttributes();
                            if($_SESSION['user']['id'] == $attributListe['user_id']){
                                $proprio = true;
                            }  
                        }            
                    }
                    $liste = Liste::all();
                    $found = false;
                    foreach ($liste as $list){
                        $attributListe = $list->getAttributes();
                        $l = Liste::find($attributListe['no']);
                        if ($temp.$attributListe['tokenSurprise'] ==  $_SERVER[ 'REQUEST_URI' ]){
                            $vueListe = new VueListe($l,$rq,"Surprise");
                            $rs->getBody()->write($vueListe->render());
                            $found = true;
                         }
                        }
                        if(!$found){
                            $l = Liste::find($num);
                    if ($proprio){ //si l'utilisateur est le propriétaire de la liste
                        $etat = "Proprio";
                        $vueListe = new VueListe($l,$rq,$etat);
                        $rs->getBody()->write($vueListe->render());
                    } else { //si l'utilisateur n'est pas le propriétaire de la liste
                        $users = User::all();
                        foreach ($users as $user){
                            $attributUser = $user->getAttributes();
                            if ($attributUser['id'] ==  $_SESSION['user']['id']){
                                if($attributUser['roleid'] >= 3 ){ //si l'utilisateur est admin
                                    $etat = "Admin";
                                    if($num<10000){ // si il s'agit d'un ID de liste
                                        $l = Liste::find($num);
                                        $vueListe = new VueListe($l,$rq,$etat);
                                        $rs->getBody()->write($vueListe->render());
                                    } else { //si il s'agit d'un Token de liste
                                        $liste = Liste::all();
                                        foreach ($liste as $list){
                                            $attributListe = $list->getAttributes();
                                            $l = Liste::find($attributListe['no']);
                                            if ($temp.$attributListe['tokenEdition'] ==  $_SERVER[ 'REQUEST_URI' ]){
                                                $vueListe = new VueListe($l,$rq,$etat);
                                                $rs->getBody()->write($vueListe->render());
                                             }
                                             elseif ($temp.$attributListe['tokenPartage'] ==  $_SERVER[ 'REQUEST_URI' ]){
                                                $vueListe = new VueListe($l,$rq,$etat);
                                                $rs->getBody()->write($vueListe->render());
                                            }
                                            elseif ($temp.$attributListe['tokenSurprise'] ==  $_SERVER[ 'REQUEST_URI' ]){
                                                $vueListe = new VueListe($l,$rq,$etat);
                                                $rs->getBody()->write($vueListe->render());
                                            }
                                        }
                                    }
                                } else { //si l'utilisateur n'est pas admin
                                    if($num<10000){ //si il s'agit d'un ID de liste 
                                        $l = Liste::find($num);
                                        $vueListe = new VueListe($l,$rq,"Interdit");
                                        $rs->getBody()->write($vueListe->render());
                                    } else { //si il s'agit d'un Token de liste
                                        $liste = Liste::all();
                                        foreach ($liste as $list){
                                            $attributListe = $list->getAttributes();
                                                                if ($temp.$attributListe['tokenEdition'] ==  $_SERVER[ 'REQUEST_URI' ]){
                                                                    if($attributListe['user_id'] == $attributUser['id']){
                                                                        $etat = "Proprio";
                                                                        $vueListe = new VueListe($l,$rq,$etat);
                                                                        $rs->getBody()->write($vueListe->render());
                                                                    }
                                                                 }
                                                                 elseif ($temp.$attributListe['tokenPartage'] ==  $_SERVER[ 'REQUEST_URI' ]){
                                                                    if($attributListe['user_id'] == $attributUser['id']){
                                                                        $etat = "Proprio";
                                                                        $vueListe = new VueListe($l,$rq,$etat);
                                                                        $rs->getBody()->write($vueListe->render());
                                                                    }
                                                                }
                                                                elseif ($temp.$attributListe['tokenSurprise'] ==  $_SERVER[ 'REQUEST_URI' ]){
                                                                    if($attributListe['user_id'] == $attributUser['id']){
                                                                        $etat = "Proprio";
                                                                        $vueListe = new VueListe($l,$rq,$etat);
                                                                        $rs->getBody()->write($vueListe->render());
                                                                    }
                                                                }
                                                             } 
                                                                if(!isset($etat)){
                                                                    $liste = Liste::all();
                                        foreach ($liste as $list){
                                            $attributListe = $list->getAttributes();
                                            $l = Liste::find($attributListe['no']);
                                            if ($temp.$attributListe['tokenEdition'] ==  $_SERVER[ 'REQUEST_URI' ]){
                                                $etat = "Edition";
                                                $vueListe = new VueListe($l,$rq,$etat);
                                                $rs->getBody()->write($vueListe->render());
                                             }
                                             if ($temp.$attributListe['tokenPartage'] ==  $_SERVER[ 'REQUEST_URI' ]){
                                                $etat = "VuePartage";
                                                $vueListe = new VueListe($l,$rq,$etat);
                                                $rs->getBody()->write($vueListe->render());
                                            }
                                            if ($temp.$attributListe['tokenSurprise'] ==  $_SERVER[ 'REQUEST_URI' ]){
                                                $etat = "Surprise";
                                                $vueListe = new VueListe($l,$rq,$etat);
                                                $rs->getBody()->write($vueListe->render());
                                            }
                                        }
                                                                }
                                    }
                                }
                            }       
                        }
                    }
                }
        } else { //si l'utilisateur n'est pas connecter
            if(isset($_COOKIE['WishListe2021AuChocolat'])){
                $track_user_code = $_COOKIE[ 'WishListe2021AuChocolat' ];
            }
                $l = Liste::find($num);
                if($l != null){ 
                    $attributListe = $l->getAttributes();
                    if($track_user_code == $attributListe['cookieUser']){
                        $proprio = true;
                    }  
                }            
            if ($proprio){ //si l'utilisateur est le propriétaire de la liste
                $etat = "Proprio";
                $vueListe = new VueListe($l,$rq,$etat);
                $rs->getBody()->write($vueListe->render());
            } 

            elseif($num<10000){ //si il s'agit d'un ID de liste 
                $l = Liste::find($num);
                $vueListe = new VueListe($l,$rq,"Interdit");
                $rs->getBody()->write($vueListe->render());
            } else { //si il s'agit d'un Token de liste
                                        
                $liste = Liste::all();
                foreach ($liste as $list){
                    $attributListe = $list->getAttributes();
                                        if ($temp.$attributListe['tokenEdition'] ==  $_SERVER[ 'REQUEST_URI' ]){
                                            if($attributListe['cookieUser'] == $track_user_code){
                                                $etat = "Proprio";
                                                //$l = Liste::find($attributListe['']);
                                                $vueListe = new VueListe($l,$rq,$etat);
                                                $rs->getBody()->write($vueListe->render());
                                            }
                                         }
                                         elseif ($temp.$attributListe['tokenPartage'] ==  $_SERVER[ 'REQUEST_URI' ]){
                                            if($attributListe['cookieUser'] == $track_user_code){
                                                $etat = "Proprio";
                                                //$l = Liste::find($attributListe['']);
                                                $vueListe = new VueListe($l,$rq,$etat);
                                                $rs->getBody()->write($vueListe->render());
                                            }
                                        }
                                         } 
                                        if(!isset($etat)){
                                            $liste = Liste::all();
                foreach ($liste as $list){
                    $attributListe = $list->getAttributes();
                    $l = Liste::find($attributListe['no']);
                    $temp = $rq->getUri()->getBasePath()."/liste/";
                    if ($temp.$attributListe['tokenEdition'] ==  $_SERVER[ 'REQUEST_URI' ]){
                        $etat = "EditionPasConnecter";
                        $vueListe = new VueListe($l,$rq,$etat);
                        $rs->getBody()->write($vueListe->render());
                     }
                     if ($temp.$attributListe['tokenPartage'] ==  $_SERVER[ 'REQUEST_URI' ]){
                        $etat = "VuePartage";
                        $vueListe = new VueListe($l,$rq,$etat);
                        $rs->getBody()->write($vueListe->render());
                    }
                    if ($temp.$attributListe['tokenSurprise'] ==  $_SERVER[ 'REQUEST_URI' ]){
                        $etat = "Surprise";
                        $vueListe = new VueListe($l,$rq,$etat);
                        $rs->getBody()->write($vueListe->render());
                    }
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
        $date = filter_var($parsed['date'], FILTER_SANITIZE_STRING);
        $liste = new Liste();
        $liste->titre = $nom;
        $liste->expiration = $date;
        $liste->description = $descr;
        $liste->tokenEdition = random_int(10000,intval(9999999999));
        $liste->tokenPartage = random_int(10000,intval(9999999999));
        $liste->tokenSurprise = random_int(10000,intval(9999999999));
        if(Authentication::isConnected()){
            $liste->user_id = $_SESSION['user']['id'];
        } else {
            {
                //création d'un cookie durant 1mois (qui permet de stocker les lists mêmes si l'utilisateur n'est pas connecte)
                if(!isset($_COOKIE['WishListe2021AuChocolat'])){
                $nomCookie = 'WishListe2021AuChocolat';
                $valCookie = random_int(intval(-99999999999),-2);
                setcookie($nomCookie, $valCookie, time() + 60*60*24*30);
                $liste->cookieUser = $valCookie;
                } else {
                    $liste->cookieUser = $_COOKIE['WishListe2021AuChocolat'];
                }
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

    function supprimerItem($rq, $rs, $args) {
        if (!Authentication::isconnected()) {
            $rs->getBody()->write('<h1>Vous devez être connecté pour accéder à cette page</h1>');
            return $rs;
        }
        $vuesupprimeritem = new VueSupprimerItem($rq,$rs,$args);
        $rs->getBody()->write($vuesupprimeritem->render());
        return $rs;
    }

    function traiterItem($rq, $rs, $args) {
        if (!isset($_SESSION['id_liste'])) {
            $rs->getBody()->write("Vous n'avez pas acces a cette page");
            return $rs;
        }
        //suppression reservation
        $resa = Reservation::where('item_id',$args['id'])->first();    
        if($resa != null){
            $resa->delete();
        }
        //suppression item
        $item = Item::find($args['id']);
        $item->delete();
        echo "suppression";
        return $rs->withRedirect( $rq->getUri()->getBasePath() . "/liste/" .$args['idliste']);
    }

    function partageListe($rq, $rs, $args) {
        $num = $args['id'];
       // if (!Authentication::isconnected()) {
        //    $rs->getBody()->write('<h1>Vous devez être connecté pour accéder à cette page</h1>');
        //    return $rs;
       // }
        $liste = Liste::all();
        $temp = "/projetphp/partageListe/";
        foreach ($liste as $list){
            $attributListe = $list->getAttributes();
             if ($temp.$attributListe['tokenEdition'] ==  $_SERVER[ 'REQUEST_URI' ]){
                $vuePartage = new VuePartage($rq,$rs,$args,$num,"Edition");
                $rs->getBody()->write($vuePartage->render());
            } 
            if ($temp.$attributListe['tokenPartage'] ==  $_SERVER[ 'REQUEST_URI' ]){
                $vuePartage = new VuePartage($rq,$rs,$args,$num,"Partage");
                $rs->getBody()->write($vuePartage->render());
            } 
            if ($temp.$attributListe['no'] ==  $_SERVER[ 'REQUEST_URI' ]){
                $vuePartage = new VuePartage($rq,$rs,$args,$num,"Admin");
                $rs->getBody()->write($vuePartage->render());
            } 
        }
        return $rs;
    }

    public function editerListe($rq, $rs, $args){
        $vueEdit = new VueEditerListe(Liste::find($args['id']),$rq);
        $rs->getBody()->write($vueEdit->render());
        return $rs;
    }

    public function majListe($rq,$rs,$args){

        //recuperation des données
        $parsed = $rq->getParsedBody();
        $nom = filter_var($parsed['nom'], FILTER_SANITIZE_STRING);
        $descr = filter_var($parsed['descr'], FILTER_SANITIZE_STRING);
        $date = filter_var($parsed['date'], FILTER_SANITIZE_STRING);
        
        //maj liste
        $liste = Liste::find($args['id']);
        if(!isset($nom)){
            $liste->titre = $nom;
        }
        if(!isset($descr)){
            $liste->description = $descr;
        }
        if(!isset($date)){
            $liste->expiration = $date;
        }
        $liste->save();
        //redirection
        return $rs->withRedirect( $rq->getUri()->getBasePath() . "/liste/" .$args['id']);
    }

    public function rendrePublique($rq,$rs,$args){
        $num = $args['id'];
        $l = Liste::find($num);
        $l->public = 1;
        $l->save();
        return $rs;
    }

    public function rendrePrivee($rq,$rs,$args){
        $num = $args['id'];
        $l = Liste::find($num);
        $l->public = 0;
        $l->save();
        return $rs;
    }

}