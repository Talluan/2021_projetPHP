<?php

namespace wish\vues;

class VueListe
{
    private $model;
    private $rq;
    function __construct($liste,$rq)
    {
        $this->model = $liste;
        $this->rq = $rq;
    }

    public function render()
    {
        $content = $this->htmlListe();
        $html = new Vue($content,'Liste',$this->rq);
        return $html->getHtml();
    }

    public function htmlListe(){
        $res ="";
        $res .='<div class="container">';
		$res .='<div class="row">';
        foreach ($this->model->items as $value) {
            $attributs=$value->getAttributes();    
			$res .= '<div class="col-sm-3">';
			$res .= '<div class="membre-corps"> <div>';
			$res .= $attributs['nom'];
			$res .= "<br><img src='".$this->rq->getUri()->getBasePath()."/img/".$attributs['img']."' alt='".$attributs['nom']."' heigth='100' width='100' > <br>".$attributs['tarif']."€ </div>";
			$res .= '<div class="btn btn-primary">';
			$res .= "<a href=' ' class='membre-btn-voir'>Voir</a> </div> </div> </div> </div> </div>";
        }
        return $res;
    }
}
