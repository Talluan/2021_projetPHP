<?php

namespace wish\vues;

use wish\models\Item;

class VueSupprimerItem
{
    private $modele;
    private $args;

    function __construct($rq,$rs,$args){
        $this->rq = $rq;
        $this->rs = $rs;
        $this->args = $args;
    }

    public function render(){
        $content = $this->supprimerItem();
        $html = new Vue($content, 'Supprimer item', $this->rq);
        return $html->getHtml();
    }

    public function supprimerItem(){
        //recherche item
        $item = Item::find( $this->args['id']);
        $id_item = $item->getAttribute('id');
        $nom_item = $item->getAttribute('nom');
        $descr_item = $item->getAttribute('descr');
        $liste_id = $item->getAttribute('liste_id');
        $img_item = $item->getAttribute('img');
        $img_item = $this->rq->getUri()->getBasePath().'/img/'.$img_item;
        $url_item = $item->getAttribute('url');
        $tarif_item = $item->getAttribute('tarif');
        //affichage
        $uri = $this->rq->getUri()->getBasePath()."/supprimeritem";
        $html = '
            <div class="container-sm">
                <h1>Item numéro '. $id_item .'</h1>
                <div class="row align-items-center">
                    <div class="col justify-content-md-center text-center align-middle">
                    <div class="row">
                        <div class="col-6">
                            <h2>Nom de l\'item</h2>
                        </div>
                        <div class="col-6">'
                            .$nom_item.
                        '</div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <h2>Appartenance à une liste :</h2>
                        </div>
                        <div class="col-6">'
                            .$liste_id.
                        '</div>
                    </div>
                    <div class="row">
                    <div class="col-6">
                        <h2>Description :</h2>
                    </div>
                    <div class="col-6">'
                        .$descr_item.
                    '</div>
                    </div>   
                    <div class="row">
                        <div class="col-6">
                            <h2>Prix :</h2>
                        </div>
                        <div class="col-6">'
                            .$tarif_item.
                        '</div>
                        ';
                
            if (isset($this->user)) {
                $html .= '
                    <div class="col-6">
                        <h3> Réservé par : </h3>
                    </div>
                    <div class="col-6">'
                    .$this->user->pseudo.
                    '</div>';
            }

                $html.= '</div>   
                </div>
                <div class="col-4">
                    <img src="'.$img_item.'"style="object-fit:contain;width:300px;height:auto;">
                </div>
                <div class="row">
                <div class="col-8">
                    <div class="row">
                        <div class="col justify-content-md-center text-center align-middle">';

                        // Si il y a quelqu'un qui le réserve
                        if (isset($this->user)) {
                            // Si la personne est connectée
                            if (isset($_SESSION['user'])) {
                                // On vérifie que la personne connectée est celle qui a réservé
                                if ($this->user->id == $_SESSION['user']['id']) {
                                    $html .= '
                                        <a href="'. $uri. '/item/'.$id_item.'/annuler">
                                            <button type="button" class="btn btn-primary btn-lg">Annuler ma réservation</button>
                                        </a>
                                    </div>
                                    ';
                                }
                                else {
                                    $html .= '
                                </div>
                                ';
                                }
                            }


                        }
                        else {
                            $html .= '
                            </div>';
                        }

                    $html .='
                    </div>
                </div>
            </div>

        </div>';
        $src = $this->rq->getUri()->getBasePath()."/liste/".$liste_id;
        $uri = $this->rq->getUri();
        $html .= <<<HTML
        
        <div class="container">
        <form action="$uri" method="post" enctype="multipart/form-data">
            <input href="$src" type="submit" class="btn btn-primary btn-lg" value="Supprimer définitivement l'item">
        </form>
        </div>

HTML;
        return $html;
    }
}