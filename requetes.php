<?php

class requetes
{
    

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

    public static function getItem($connection) {

        
    }


}
