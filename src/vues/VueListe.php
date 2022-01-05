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
        $message = '<div class="container">
                        <form action="$host/projetphp/connexion" method="POST">
                            <div class="row">
                                <div class="col">
                                    <label for="nomListe">Votre message</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                                <hr>
                                <button class="btn btn-primary" type="submit">Publier</button>
                            </div>
                        </form>
                    </div>' ;
        $res .= $message;
        foreach ($this->model->items as $value) {
            $attributs=$value->getAttributes();    
			$res .= '<div class="col-sm-3">';
			$res .= '<div class="membre-corps"> <div>';
			$res .= $attributs['nom'];
			$res .= "<br><img src='".$this->rq->getUri()->getBasePath()."/img/".$attributs['img']."' alt='".$attributs['nom']."' heigth='100' width='100' > <br>".$attributs['tarif']."€ </div>";
			$res .= '<div class="btn btn-primary">';
			$res .= "<a class='btn btn-primary' href=".$this->rq->getUri()->getBasePath()."\/item/".$attributs['id'].">Voir</a>";
            $res .= '</div> </div> </div> </div> </div>';
        }
        $res .= "<a class='membre-btn-partager'>Partager la liste</a>";
        $res .= "<div id='sharelink'>
                    xamp
                </div>";
        return $res;
    }
}
