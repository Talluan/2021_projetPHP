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
        $html = new Vue($content,'Liste');
        return $html->getHtml();
    }

    public function htmlListe(){
        $res ="";
        foreach ($this->model->items as $value) {
            $attributs=$value->getAttributes();
            $res .= "<p>";
            $res .= $attributs['nom']." ".$attributs['tarif']."€ ".$attributs['descr'];
            $res .= "<img src='../img/".$attributs['img']."' alt='".$attributs['nom']."' heigth='100' width='100' />";
            $res .= "</p>";
        }
        return $res;
    }
}
