<?php

namespace wish\bd;

use \PDO;
use \PDOException;

class connectionFactory {

    private static $param;
    private static $connexion;
    
    static function setConfig($file) {
        $tab = parse_ini_file($file);
        self::$param = $tab;
    }

    static function makeConnection (){

        if(!isset(self::$connexion)) {
            self::setConfig('db.config.ini');
            try{
                self::$connexion = new PDO('mysql:host=' . self::$param['host'] . ';port=' . self::$param['port'] . ';dbname=' . self::$param['database'],
                    self::$param['username'], self::$param['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES UTF8MB4', 
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
              }catch (PDOException $e){
                echo($e->getMessage() . "<br>");
                echo 'Erreur : Impossible de se connecter  à la BDD !';
                die();
            }
        }
        return self::$connexion;

    }

}