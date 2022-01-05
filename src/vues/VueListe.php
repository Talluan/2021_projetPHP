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
        
        $res.='
        <div class="container">
        <div class="row">
        ';
        foreach ($this->model->items as $value) {
            $attributs=$value->getAttributes();
            $nom=$attributs['nom'];
            $img=$this->rq->getUri()->getBasePath()."/img/".$attributs['img'];
            $voir=$this->rq->getUri()->getBasePath()."\/item/".$attributs['id'];
            $html=<<<END
            <div class="col-sm-3">
					<div class="membre-corps">
						<div>
							$nom
							<br><img src="$img" alt="" width="100" height="100"> 
						</div>
						<div class="mambre-btn">
							<a href="$voir" class='btn btn-primary'>Voir</a>
						</div>
					</div>
				</div>
END;
			// $res .= '<div class="col-sm-3">';
			// $res .= '<div class="membre-corps">';
			// $res .= $attributs['nom'];
			// $res .= "<br><img src='".$this->rq->getUri()->getBasePath()."/img/".$attributs['img']."' alt='".$attributs['nom']."' heigth='100' width='100' > <br>".$attributs['tarif']."€ </div>";
			// $res .= '<div class="btn btn-primary">';
			// $res .= "<a class='btn btn-primary' href=".$this->rq->getUri()->getBasePath()."\/item/".$attributs['id'].">Voir</a>";
            // $res .= '</div> </div> </div> </div> </div>';
        $res.=$html;

        }
        $res .= "</div><br>";
        $ajouter = $this->rq->getUri()->getBasePath()."/ajouteritem";
        $res .= "<a class='btn btn-success' href='$ajouter'>Ajouter un item</a><a class='btn btn-info'>Partager la liste</a>";
        $message = '
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
                    ' ;
        $res .= $message;
        $res .= "</div>";

        return $res;
    }
}
