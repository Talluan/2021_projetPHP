<?php

namespace wish\controleur;

use wish\models\User;
use wish\exception\WrongPasswordException;

class Authentication {

    /**
     * méthode qui permet de créer un nouvel utilisateur et le sauvegarde dans la bdd
     * @param pseudo nom de l'utilisateur
     * @param password mot de passe pas encore hashé
     */
    static function createUser($pseudo, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $u = new User();
        $u->pseudo = $pseudo;
        $u->passwd = $hash;
        $u->roleid = 2;
        $u->save();
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