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
            <div class="container-sm">
                <h1>Item numéro '. $id .'</h1>
                <div class="row align-items-center">
                    <div class="col justify-content-md-center text-center align-middle">
                    <div class="row">
                        <div class="col-8">
                            <h2>Appartenance à une liste :</h2>
                        </div>
                        <div class="col-4">'
                            .$liste_id.
                        '</div>
                    </div>
                    <div class="row">
                    <div class="col-8">
                        <h2>Description :</h2>
                    </div>
                    <div class="col-4">'
                        .$descr.
                    '</div>
                    </div>   
                    <div class="row">
                        <div class="col-8">
                            <h2>Prix :</h2>
                        </div>
                        <div class="col-4">'
                            .$tarif.
                        '</div>
                    </div>   
                    </div>
                    <div class="col-4">
                        <img src="'.$imgurl.'"style="object-fit:contain;width:300px;height:auto;">
                    </div>
                </div>
            </div>';
        return $html;
    }
}
