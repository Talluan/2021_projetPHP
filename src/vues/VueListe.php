<?php

namespace wish\vues;
use wish\models\User;

//use wish\models\User as User;

class VueListe
{
    private $model;
    private $rq;
    private $etat;
    
    function __construct($liste,$rq,$e)
    {
        $this->model = $liste;
        $this->rq = $rq;
        $this->etat = $e;
    }

    public function render()
    {
        $content = $this->htmlListe();
        $html = new Vue($content,'Liste',$this->rq);
        return $html->getHtml();
    }

    public function htmlListe()
    {
        if($this->etat == "Admin")
        return $this->vueAdmin();
        if($this->etat == "Edition")
        return $this->vueEdition();
        if($this->etat == "EditionPasConnecter")
        return $this->vueEditionPasConnecter();
        if($this->etat == "VuePartage")
        return $this->vuePartage();
        if($this->etat == "Interdit")
        return $this->vueInterdit();
        if($this->etat == "Surprise")
        return $this->vueSurprise();
        if($this->etat == "Proprio")
        return $this->vueProprio();
}

        // si l'utilisateur n'es pas sensé avoir accès à la liste !
        private function vueInterdit(){
            $res ="<p> Vous n'avez pas accès à ceci ! </p>";
            return $res;
        }    
        
        // si l'utilisateur n'est pas connecter mais qu'il est sur un TokenEdition
        private function vueEditionPasConnecter(){
            $res='
            <div class="container">
            <h1>'.$this->model->titre.'</h1>
            <p class"font-italic">'.$this->model->description.'</p>
            <div class="row">
            ';

foreach ($this->model->items as $value) {
    $attributs=$value->getAttributes();
    $nom=$attributs['nom'];
    $img=$this->rq->getUri()->getBasePath()."/img/".$attributs['img'];
    $voir=$this->rq->getUri()->getBasePath()."/item/".$attributs['id'];
    $html =<<<END
    <div class="col-sm-3">
            <div class="membre-corps">
                <div>
                    $nom
                    <br><img src="$img" alt="" width="100" height="100"> 
                </div>
                <div class="mambre-btn">
                     <a href="$voir" class='btn btn-primary'>Voir</a>
                </div>
END;
    
        $html .= '<div class="mambre-btn">
                        <a href="'.$voir.'" class="btn btn-primary">Supprimer</a>
                    </div>';
    $html .= '</div></div>';
    $res.=$html;
}
$res .= "</div><br>";
$ajouter = $this->rq->getUri()->getBasePath()."/ajouteritem";
$modifierDate = $this->rq->getUri()->getBasePath()."/ajouterDateExpiration";
$partage = $this->rq->getUri()->getBasePath()."/partageListe/";
$partage .= $_SESSION['id_liste'];
$res .= "<a class='btn btn-success' href='$ajouter'>Ajouter un item</a> <a class='btn btn-warning' href='$modifierDate' >Modifier date d'expiration</a> <a class='btn btn-info' href='$partage'>Partager la liste</a>";
$liste_messages = 
"</div>
    <hr>
    <div class='container'>
        <div class='row'>
            <div class='col-sm-3'>
                <div class='membre-corps'>
                <div>
                        <h3>Mode : $this->etat</h3>
                    </div>
                    <div>
                        <h3>Message</h3>
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

        //point de vue d'un utilisateur connecté qui peut intérageur avec la liste !
        private function vueEdition(){
            $res='
                    <div class="container">
                    <h1>'.$this->model->titre.'</h1>
                    <p class"font-italic">'.$this->model->description.'</p>
                    <div class="row">
                    ';

        foreach ($this->model->items as $value) {
            $attributs=$value->getAttributes();
            $nom=$attributs['nom'];
            $img=$this->rq->getUri()->getBasePath()."/img/".$attributs['img'];
            $voir=$this->rq->getUri()->getBasePath()."/item/".$attributs['id'];
            $html =<<<END
            <div class="col-sm-3">
					<div class="membre-corps">
						<div>
							$nom
							<br><img src="$img" alt="" width="100" height="100"> 
						</div>
						<div class="mambre-btn">
						 	<a href="$voir" class='btn btn-primary'>Voir</a>
						</div>
END;
            
                $html .= '<div class="mambre-btn">
                                <a href="'.$voir.'" class="btn btn-primary">Supprimer</a>
                            </div>';
            $html .= '</div></div>';
            $res.=$html;
        }
        $res .= "</div><br>";
        $ajouter = $this->rq->getUri()->getBasePath()."/ajouteritem";
        $modifierDate = $this->rq->getUri()->getBasePath()."/ajouterDateExpiration";
        $partage = $this->rq->getUri()->getBasePath()."/partageListe/";
        $partage .= $_SESSION['id_liste'];
 $res .= "<a class='btn btn-success' href='$ajouter'>Ajouter un item</a> <a class='btn btn-warning' href='$modifierDate' >Modifier date d'expiration</a> <a class='btn btn-info' href ='$partage'>Partager la liste</a>";
        $liste_messages = 
        "</div>
            <hr>
            <div class='container'>
                <div class='row'>
                    <div class='col-sm-3'>
                        <div class='membre-corps'>
                        <div>
                                <h3>Mode : $this->etat</h3>
                            </div>
                            <div>
                                <h3>Message</h3>
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

        //point de vue d'un propriétaire de liste
        private function vueProprio(){
            $res='
                    <div class="container">
                    <h1>'.$this->model->titre.'</h1>
                    <p class"font-italic">'.$this->model->description.'</p>
                    <div class="row">
                    ';

        foreach ($this->model->items as $value) {
            $attributs=$value->getAttributes();
            $nom=$attributs['nom'];
            $img=$this->rq->getUri()->getBasePath()."/img/".$attributs['img'];
            $voir=$this->rq->getUri()->getBasePath()."/item/".$attributs['id'];
            $supprimer=$this->rq->getUri()->getBasePath()."/liste/".$this->model->getAttributes()['no']."/supprimeritem/".$attributs['id'];
            $html =<<<END
            <div class="col-sm-3">
					<div class="membre-corps">
						<div>
							$nom
							<br><img src="$img" alt="" width="100" height="100"> 
						</div>
						<div class="mambre-btn">
						 	<a href="$voir" class='btn btn-primary'>Voir</a>
						</div>
END;
            
                $html .= '<div class="mambre-btn">
                                <a href="'.$supprimer.'" class="btn btn-primary">Supprimer</a>
                            </div>';
            $html .= '</div></div>';
            $res.=$html;
        }
        $res .= "</div><br>";
        $ajouter = $this->rq->getUri()->getBasePath()."/ajouteritem";
        $modifierDate = $this->rq->getUri()->getBasePath()."/ajouterDateExpiration";
        $partage = $this->rq->getUri()->getBasePath()."/partageListe/";
        $partage .= $_SESSION['id_liste'];
        $res .= "<a class='btn btn-success' href='$ajouter'>Ajouter un item</a> <a class='btn btn-warning' href='$modifierDate' >Modifier date d'expiration</a> <a class='btn btn-info' href ='$partage'>Partager la liste</a>";
        $liste_messages = 
        "</div>
            <hr>
            <div class='container'>
                <div class='row'>
                    <div class='col-sm-3'>
                        <div class='membre-corps'>
                        <div>
                                <h3>Mode : $this->etat</h3>
                            </div>
                            <div>
                                <h3>Message</h3>
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
        $res .= <<<HTML
        <hr>
        <div>
        <a class="btn btn-primary" href="$path/modifierListe/$list_id">Modifier la liste</a>

        </div>
HTML;
        $res .= "</div>";

        return $res;
        }     

        //point de vue normal (pas besoin d'être connnécté), mais ne peut pas intéragire avec la liste (ne peut pas réserver un item, laisser de message, etc...)
        private function vuePartage(){
            $res='
            <div class="container">
            <h1>'.$this->model->titre.'</h1>
            <p class"font-italic">'.$this->model->description.'</p>
            <div class="row">
            ';

foreach ($this->model->items as $value) {
    $attributs=$value->getAttributes();
    $nom=$attributs['nom'];
    $img=$this->rq->getUri()->getBasePath()."/img/".$attributs['img'];
    $voir=$this->rq->getUri()->getBasePath()."/item/".$attributs['id'];
    $html =<<<END
    <div class="col-sm-3">
            <div class="membre-corps">
                <div>
                    $nom
                    <br><img src="$img" alt="" width="100" height="100"> 
                </div>
                <div class="mambre-btn">
                     <a href="$voir" class='btn btn-primary'>Voir</a>
                </div>
END;
    
    
    $html .= '</div></div>';
    $res.=$html;
}
$res .= "</div><br>";
$liste_messages = 
"</div>
    <hr>
    <div class='container'>
        <div class='row'>
            <div class='col-sm-3'>
                <div class='membre-corps'>
                <div>
                        <h3>Mode : $this->etat</h3>
                    </div>
                    <div>
                        <h3>Message</h3>
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

        //point de vue de celui qui recoit tous les cadeaux (il faut mettre un timer tant que la date n'est pas la bonne)
        private function vueSurprise(){
            $t = $this->model->getAttributes()['expiration'];
            $timestamp1 = strtotime($t);
            $t2 = time();
            $res='
            <div class="container">
            <h1>'.$this->model->titre.'</h1>
            <p class"font-italic">'.$this->model->description.'</p>
            <div class="row">
            ';
            
            if($timestamp1>$t2){

                $res .=<<<END
                <p> Vous ne pouvez pas voir ceci avant la date : $t </p>
END;
            } else {
                $res .=<<<END
                <p> AFFICHAGE CADEAUX </p>             
END;
                foreach ($this->model->items as $value) {
                    $attributs=$value->getAttributes();
                    $nom=$attributs['nom'];
                    $img=$this->rq->getUri()->getBasePath()."/img/".$attributs['img'];
                    $voir=$this->rq->getUri()->getBasePath()."/item/".$attributs['id'];
                    $html =<<<END
                    <div class="col-sm-3">
                            <div class="membre-corps">
                                <div>
                                    $nom
                                    <br><img src="$img" alt="" width="100" height="100"> 
                                </div>
                                <div class="mambre-btn">
                                     <a href="$voir" class='btn btn-primary'>Voir</a>
                                </div>
END;
                  
                    $html .= '</div></div>';
                    $res.=$html;
        
                }
                
            }
            
            return $res;
        }
        
        //point de vue d'un admin sur les liste <10000
        //si id > 10000 c'est un token accesible par tous et pas seulement un admin
        private function vueAdmin(){
                    $res='
                    <div class="container">
                    <h1>'.$this->model->titre.'</h1>
                    <p class"font-italic">'.$this->model->description.'</p>
                    <div class="row">
                    ';

        foreach ($this->model->items as $value) {
            $attributs=$value->getAttributes();
            $nom=$attributs['nom'];
            $img=$this->rq->getUri()->getBasePath()."/img/".$attributs['img'];
            $voir=$this->rq->getUri()->getBasePath()."/item/".$attributs['id'];
            $html =<<<END
            <div class="col-sm-3">
					<div class="membre-corps">
						<div>
							$nom
							<br><img src="$img" alt="" width="100" height="100"> 
						</div>
						<div class="mambre-btn">
						 	<a href="$voir" class='btn btn-primary'>Voir</a>
						</div>
END;
            
                $html .= '<div class="mambre-btn">
                                <a href="'.$voir.'" class="btn btn-primary">Supprimer</a>
                            </div>';
            
            $html .= '</div></div>';
            $res.=$html;

        }
        $res .= "</div><br>";
        $ajouter = $this->rq->getUri()->getBasePath()."/ajouteritem";
        $modifierDate = $this->rq->getUri()->getBasePath()."/ajouterDateExpiration";
        $partage = $this->rq->getUri()->getBasePath()."/partageListe/";
        $partage .= $_SESSION['id_liste'];
        $res .= "<a class='btn btn-success' href='$ajouter'>Ajouter un item</a> <a class='btn btn-warning' href='$modifierDate' >Modifier date d'expiration</a> <a class='btn btn-info'  href='$partage'>Partager la liste</a>";
        $liste_messages = 
        "</div>
            <hr>
            <div class='container'>
                <div class='row'>
                    <div class='col-sm-3'>
                        <div class='membre-corps'>
                        <div>
                                <h3>Mode : $this->etat</h3>
                            </div>
                            <div>
                                <h3>Message</h3>
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
        $res .= <<<HTML
        <hr>
        <div>
            <a class="btn btn-primary" href="$path/modifierListe/$list_id">Modifier la liste</a>
        </div>
HTML;
        $res .= "</div>";

        return $res;
    }
    


}