<?php

namespace wish\vues;

use wish\models\User as User;

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
        $modifierDate = $this->rq->getUri()->getBasePath()."/ajouterDateExpiration";
        $res .= "<a class='btn btn-success' href='$ajouter'>Ajouter un item</a> <a class='btn btn-warning' href='$modifierDate' >Modifier date d'expiration</a> <a class='btn btn-info'>Partager la liste</a>";
        $liste_messages = 
        "</div>
            <hr>
            <div class='container'>
                <div class='row'>
                    <div class='col-sm-3'>
                        <div class='membre-corps'>
                            <div>
                                <h3>Messages</h3>
                            </div>
                            <div class='row'>";
        //recherche des messages de la liste
        $n = 0;
        foreach ($this->model->messages as $value) {
            $n += 1;
            $attributs=$value->getAttributes();
            $pseudoid = $attributs['pseudo_id'];
            $pseudo = User::where('id','=',$pseudoid)->first()->pseudo;
            $liste_messages .= "<div>".$pseudo.' : "'.$attributs['message'].'"'."</div>";
        }
        if($n === 0){
            $liste_messages .= "<div>Pas de message concernant cette liste</div>";
        }
        //ajout des messages à l'html
        $liste_messages .= "
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <hr>";
        $res .= $liste_messages;
        $host = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'];
        $list_id = $this->model->no;
        $path = $this->rq->getUri()->getBasePath();
        $placeholder = "";
        if(isset($_SESSION['user'])){
            $placeholder = "Rédigez votre message ici";
        }
        $message = <<<HTML
                        <form action="$path/liste/$list_id" method="POST">
                        <div class='container'>
                            <div class="row">
                                <div class="col">
                                    <label for="nomListe">Publier un message</label>
                                    <textarea class="form-control" name="message" placeholder='$placeholder' id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                                <hr>
                                <button class="btn btn-primary" type="submit">Publier</button>
                            </div>
                        </form>
HTML;
        if(isset($_SESSION['user'])){
            $res .= $message;
        }
        $res .= "</div>";

        return $res;
    }
}
