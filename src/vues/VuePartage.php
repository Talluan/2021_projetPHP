<?php

namespace wish\vues;
use wish\models\Liste;

class VuePartage
{
    private $model;
    private $num;
    private $etat;

    function __construct($rq,$rs,$args,$num,$etat)
    {
        $this->rq = $rq;
        $this->num = $num;
        $this->etat = $etat;
    }

    public function render()
    {
        $content = $this->partage();
        $html = new Vue($content, 'Partage de Liste', $this->rq);
        return $html->getHtml();
    }

    public function partage()
    {
        $res ="";
        $return = "/projetphp/liste/".$this->num;
        $te = $this->rq->getUri();
        $tr = $_SERVER['REQUEST_URI'];
        $newphrase = str_replace($tr, "/projetphp/liste/", $te);

    $temp = $this->rq->getUri();
   // $newphrase = str_replace($healthy, $yummy, $temp);
        if($this->etat == "Admin"){
            $liste = Liste::all();
            foreach ($liste as $list){
                $attributListe = $list->getAttributes();    
                $temp = $this->rq->getUri()."/liste/";
                if ($attributListe['no'] == $this->num){
                   $tokEdition = $newphrase.$attributListe['tokenEdition'];
                   $tokPartage = $newphrase.$attributListe['tokenPartage'];
                   $tokSurprise = $newphrase.$attributListe['tokenSurprise'];
                    $res .= <<<END
                    <div class="container">
                    <a class='btn btn-success' href='$return'>Retour</a>
                    <li class="nav-item d-flex">
                        $tokEdition    | Lien Edition
                    </li>
                    <li class="nav-item d-flex">
                        $tokPartage    | Lien Partage
                    </li>
                    <li class="nav-item d-flex">
                        $tokSurprise    | Lien Surprise
                    </li>
                    </div> 
END;
                } 
            }
        }
        if($this->etat == "Partage"){
            $liste = Liste::all();
            foreach ($liste as $list){
                $attributListe = $list->getAttributes();    
                $temp = $this->rq->getUri()."/liste/";
                if ($attributListe['tokenPartage'] == $this->num){
                   $tokEdition = $newphrase.$attributListe['tokenEdition'];
                   $tokPartage = $newphrase.$attributListe['tokenPartage'];
                   $tokSurprise = $newphrase.$attributListe['tokenSurprise'];
                    $res .= <<<END
                    <div class="container">
                    <a class='btn btn-success' href='$return'>Retour</a>
                    <li class="nav-item d-flex">
                        $tokEdition    | Lien Edition
                    </li>
                    <li class="nav-item d-flex">
                        $tokPartage    | Lien Partage
                    </li>
                    <li class="nav-item d-flex">
                        $tokSurprise    | Lien Surprise
                    </li>
                    </div> 
END;
                } 
            }
        }
        if($this->etat == "Edition"){
            $liste = Liste::all();
            foreach ($liste as $list){
                $attributListe = $list->getAttributes();    
                $temp = $this->rq->getUri()."/liste/";
                if ($attributListe['tokenEdition'] == $this->num){
                   $tokEdition = $newphrase.$attributListe['tokenEdition'];
                   $tokPartage = $newphrase.$attributListe['tokenPartage'];
                   $tokSurprise = $newphrase.$attributListe['tokenSurprise'];
                    $res .= <<<END
                    <div class="container">
                    <a class='btn btn-success' href='$return'>Retour</a>
                    <li class="nav-item d-flex">
                        $tokEdition    | Lien Edition
                    </li>
                    <li class="nav-item d-flex">
                        $tokPartage    | Lien Partage
                    </li>
                    <li class="nav-item d-flex">
                        $tokSurprise    | Lien Surprise
                    </li>
                    </div> 
END;
                } 
            }
        }

        return $res;
    }
}
