<?php

namespace wish\vues;

class VueListes
{
    private $model;
    function __construct($liste,$rq)
    {
        $this->model = $liste;
        $this->rq=$rq;
    }

    public function render()
    {
        $content = $this->htmlListe();
        $html = new Vue($content,'Listes',$this->rq);
        return $html->getHtml();
    }

    public function htmlListe()
    {
        $res = "";
        foreach ($this->model as $liste) {
            $attributs = $liste->getAttributes();
            $res .= "<div class='liste'>";
            $res .= "<h2>" . $attributs['titre'] . "</h2>";
            $res .= "<p>" . $attributs['description'] . "</p>";
            $res .= "<p> date d'expiration : " . $attributs['expiration'] . "</p>";
        }

        return $res;
    }
}
