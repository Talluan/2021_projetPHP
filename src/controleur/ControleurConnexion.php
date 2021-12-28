<?php

namespace wish\controleur;

use wish\vues\VueConnexion;
use wish\vues\Vue;
use wish\models\User;
use wish\exception\WrongPasswordException;

class ControleurConnexion {

    /**
     * Permet à un utilisateur de se connecter
     * @param rq objet contenant le mdp et le pseudo
     * @param rs objet de retour contenant la vue 
     * @param args arguments de l'url
     */
    static function seConnecter($rq, $rs, $args) {
        $parsed = $rq->getParsedBody();
        $pseudo = filter_var($parsed['pseudo'], FILTER_SANITIZE_STRING);
        $passw = filter_var($parsed['passw'], FILTER_SANITIZE_STRING);

        // On vérifie si il n'a pas laissé une case vide
        if ((!$pseudo || !$passw) || $pseudo == '' || $passw == '') {
            $vueConnexion = new VueConnexion($rq, 1);
        }

        // On vérifie si le mot de passe est assez long
        else if (strlen($passw) < 12) {
            $vueConnexion = new VueConnexion($rq, 2);
        }
        // Cas où les 2 étapes sont passées
        else {
            $u = User::where('pseudo', $pseudo)->first();
            // On vérifie que l'utilisateur existe
            if (!isset($u)) {
                $vueConnexion = new VueConnexion($rq, 4);
            }
            else {
                // On teste le mot de passe
                try {
                    Authentication::authenticate($u, $passw);
                    // Si l'authentification a marché, on redirige l'utilisateur vers l'index
                    $path = $rq->getUri()->getBasePath();
                    $rs = $rs->withRedirect($path);
                    return $rs;
                } catch ( WrongPasswordException $e) {
                    $vueConnexion = new VueConnexion($rq, 3);
                }
            }
        }
        $rs->getBody()->write($vueConnexion->render());
        return $rs;
    }


    static function seDeconnecter($rq, $rs, $args) {
        // On libère la variable de session
        Authentication::freeProfile();
        
        // On redirige l'utilisateur vers l'index
        $path = $rq->getUri()->getBasePath();
        $rs = $rs->withRedirect($path);
        return $rs;
    }

    /**
     * Permet à un utilisateur de se créer un compte
     * @param rq objet contenant le mdp et le pseudo
     * @param rs objet de retour contenant la vue 
     * @param args arguments de l'url
     */
    static function creerCompte($rq, $rs, $args) {
        $parsed = $rq->getParsedBody();
        $pseudo = filter_var($parsed['pseudo'], FILTER_SANITIZE_STRING);
        $passw = filter_var($parsed['passw'], FILTER_SANITIZE_STRING);
        // On vérifie si il n'a pas laissé une case vide
        if ((!$pseudo || !$passw) || $pseudo == '' || $passw == '') {
            $vueConnexion = new VueConnexion($rq, 1);
        }
        // On vérifie si le mot de passe est assez long
        else if (strlen($passw) < 12) {
            $vueConnexion = new VueConnexion($rq, 2);
        }
        else {
            $u = User::where('pseudo', $pseudo)->first();
            // On vérifie si l'utilisateur existe pour ne pas créer un doublon
            if (isset($u)) {
                $vueConnexion = new VueConnexion($rq, 5);
            }
            else {
                // On sauvegarde l'utilisateur
                Authentication::createUser($pseudo, $passw);
                $vueConnexion = new VueConnexion($rq);
            }
        }
        $rs->getBody()->write($vueConnexion->render());
        return $rs;
    }


    /**
     * affiche la page de connexion
     * @param rq objet contenant le mdp et le pseudo
     * @param rs objet de retour contenant la vue 
     * @param args arguments de l'url
     */
    static function afficherConnexion($rq, $rs, $args) {
        $vueConnexion = new VueConnexion($rq);
        $rs->getBody()->write($vueConnexion->render());
        return $rs;
    }

    /**
     * fonction chargée d'orienter la requête vers les bonnes méthodes
     * @param rq objet contenant le mdp et le pseudo
     * @param rs objet de retour contenant la vue 
     * @param args arguments de l'url
     */
    static function orienter($rq, $rs, $args) {
        if (isset($args['type'])) {
            if ($args['type'] == 'connex') return ControleurConnexion::seConnecter($rq, $rs, $args);
            else if ($args['type'] == 'crea') return ControleurConnexion::creerCompte($rq, $rs, $args);
        }
    }

}