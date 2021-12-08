<?php

namespace wish\vues;
use wish\vues\Vue;

class VueItem
{

    private $modele;

    public function __construct($mod)
    {
        $this->modele = $mod;
    }

    public function render()
    {
        $content = $this->htmlUnItem();
        $html = new Vue($content,'Item');
        return $html->getHtml();
    }


    public function htmlUnItem()
    {
        $res = $this->modele->getAttribute('id').'<br>';
        $res .= $this->modele->getAttribute('liste_id').'<br>';
        $res .= $this->modele->getAttribute('descr').'<br>';
        $res .= '<img src="../img/'.$this->modele->getAttribute('img').'">'.'<br>';
        $res .= $this->modele->getAttribute('url').'<br>';
        $res .= $this->modele->getAttribute('tarif').'<br>';
        return $res;
    }
}
