<?php

class requetes
{
    

    /**
     * Affiche l'ensemble des articles
     * @param $connection permettant d'accéder à la BDD 
     */
    public static function listItems($connection) {

        $stmt = $connection->prepare("select * from item");
        $stmt->execute();
        $res = $stmt->fetchAll();
        foreach ($res as $value) {
            foreach ($value as $item) {
                echo($item . " ");
            }
            echo("<br>");
        }
    }

    /**
     * Affiche 
     */
    public static function getItem($connection, $id) {

        $stmt = $connection->prepare("select * from item where id = :id");
        $stmt->execute(array(':id' => $id));
        $res = $stmt->fetch();

        foreach ($res as $key => $value) {
            echo($key . " : " . $value . "<br>");
        }
        echo("<br>");
    }


}
