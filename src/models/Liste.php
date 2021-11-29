<?php

namespace wish\objets;
use \Exception;

class Liste 
{
    private $no;
    private $user_id;
    private $titre;
    private $description;
    private $expiration;
    private $token;

    /**
     * Constructeur de Liste
     * @param $usr, ID de l'utilisateur
     * @param $titre, titre de la liste
     * @param $description, description de la liste
     * @param $expi, date d'expiration de la liste
     * @param $token, token de la liste
     */
    public function __construct($usr, $titre, $description = null, $expi = null, $token = null)
    {
        $this->user_id = $usr;
        $this->titre = $titre;
        $this->description = $description;
        $this->expiration = $expi;
        $this->token = $token;
    }

    /**
     * getter des attributs de Liste
     */
    public function __get($name)
    {
        if (property_exists ($this, $name)) {
            return $this->$name;
        }
        else throw new Exception("$name : invalid property");
    }



}
