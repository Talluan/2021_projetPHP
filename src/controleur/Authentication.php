<?php

namespace wish\controleur;

use wish\models\User;
use wish\exception\WrongPasswordException;

class Authentication {

    static function createUser($pseudo, $password) {
        $tabUsers = User::where('pseudo', '=', $pseudo)->get();
        if (isset($tabUsers)) {
            echo("DEJA PRIS");
        }
        $hash = password_hash($password, PASSWORD_DEFAULT);

    }

    /**
     * méthode qui vérifie si le mot de passe est correct
     * @param u utilisateur concerné
     * @param p mot de passe à tester
     * @return true si l'authentification a réussi
     */
    static function authenticate($u, $p) {
        $hash = $u->passwd;
        if (password_verify($p, $hash)) {
            return true;
        }
        else {
            throw new WrongPasswordException('Le mot de passe ne correspond pas.');
            return false;
        }
    }

    static function loadProfile($u) {

    }

}