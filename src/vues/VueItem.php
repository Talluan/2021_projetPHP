<?php

namespace wish\vues;
use wish\vues\Vue;

class VueItem
{

    private $modele;

    public function __construct($mod,$rq)
    {
        $this->modele = $mod;
        $this->rq=$rq;
    }

    public function render()
    {
        $content = $this->htmlUnItem();
        $html = new Vue($content,'Item',$this->rq);
        return $html->getHtml();
    }


    public function htmlUnItem()
    {
        $id = $this->modele->getAttribute('id');
        $liste_id = $this->modele->getAttribute('liste_id');
        $descr = $this->modele->getAttribute('descr');
        $path = $this->rq->getUri()->getBasePath();
        $imgurl= $path.'/img/'.$this->modele->getAttribute('img');
        $url = $this->modele->getAttribute("url");
        $tarif = $this->modele->getAttribute('tarif');
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
