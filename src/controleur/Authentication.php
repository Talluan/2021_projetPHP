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
            Authentication::loadProfile($u);
            return true;
        }
        else {
            throw new WrongPasswordException('Le mot de passe ne correspond pas.');
            return false;
        }
    }

    /**
     * méthode qui charge le profil de l'utilisateur dans une variable de session
     * @param u objet user correspondant à l'utilisateur
     */
    static function loadProfile($u) {
        $data = [
            'id' => $u->id,
            'pseudo' => $u->pseudo,
            'auth_lvl' => $u->role->auth_level
        ];
        $_SESSION['user'] = $data;
    }

    /**
     * méthode qui libère la variable de session user
     */
    static function freeProfile() {
        unset($_SESSION['user']);
    }


    static function isConnected() {
        if (isset($_SESSION['user'])) return true;
        else return false;
    }

    static function checkAccessRight() {

    }

}