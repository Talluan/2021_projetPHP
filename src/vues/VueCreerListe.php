<?php

namespace wish\vues;

class VueListe
{
    private $model;
    function __construct($liste)
    {
        $this->model = $liste;
    }

    public function render()
    {
        $content = $this->htmlListe();
        $html = new Vue($content,'Création Liste');
        return $html->getHtml();
    }

    public function htmlListe(){
        $res ="";

        return $res;
    }


}
