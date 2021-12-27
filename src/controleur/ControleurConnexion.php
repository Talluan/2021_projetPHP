<?php

namespace wish\controleur;

use wish\vues\VueConnexion;
use wish\models\User;
use wish\exception\WrongPasswordException;

class ControleurConnexion {

    /**
     * Permet à un utilisateur de se connecter
     * @param rq objet contenant le mdp et le pseudo
     * @param rs objet de retour contenant la vue 
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
                    $vueConnexion = new VueConnexion($rq);
                } catch ( WrongPasswordException $e) {
                    $vueConnexion = new VueConnexion($rq, 3);
                }
            }
        }
        $rs->getBody()->write($vueConnexion->render());
        return $rs;
    }

    /**
     * crée une nouvelle liste
     * @param rq objet contenant le mdp et le pseudo
     * @param rs objet de retour contenant la vue 
     */
    static function afficherConnexion($rq, $rs, $args) {
        $vueConnexion = new VueConnexion($rq);
        $rs->getBody()->write($vueConnexion->render());
        return $rs;
    }
}