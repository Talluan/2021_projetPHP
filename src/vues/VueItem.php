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
        $id = $this->modele->getAttribute('id');
        $liste_id = $this->modele->getAttribute('liste_id');
        $descr = $this->modele->getAttribute('descr');
        $imgurl= '../img/'.$this->modele->getAttribute('img');
        $url = $this->modele->getAttribute("url");
        $tarif = $this->modele->getAttribute('tarif');
        //
        echo $url;
        $html = '
            <div class="row row-cols-6">
                <div class="item_id">'.$id.'</div>
                <div class="item_liste_id">'.$liste_id.'</div>
                <div class="item_descr">'.$descr.'</div>
                <img src="'.$imgurl.'">
                <div class="item_url">'.$url.'</div>
                <div class="item_tarif">'.$tarif.'</div>
            </div>';
        return $html;
    }
}
