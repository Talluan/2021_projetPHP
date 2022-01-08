<?php

namespace wish\controleur;

use wish\models\Item;
use wish\vues\VueItem;
use wish\controleur\Authentication;
use wish\vues\VueAjouterItem;

class ControleurItem{
    
    /*
    *fonction qui renvoie l'item demande grace a son id dans l'URL
    *@return le code html corespondant a la vue
    */
    public static function getItem($rq,$rs,$args) {
        $id_item = $args['id'];
        $item =  Item::find($id_item);
        $vueitem = new VueItem($item,$rq);
        $rs->getBody()->write($vueitem->render());
        return $rs;
    }

    public function traiterItem($rq,$rs,$args) {
        if(!isset($_SESSION['id_liste'])){
            $rs->getBody()->write("Vous n'avez pas acces a cette page");
            return $rs;
        }
        $parsed = $rq->getParsedBody();
        $nom = filter_var($parsed['nom'], FILTER_SANITIZE_STRING);
        $descr = filter_var($parsed['description'], FILTER_SANITIZE_STRING);
        $prix = filter_var($parsed['prix'], FILTER_SANITIZE_STRING);
        $url = filter_var($parsed['url'], FILTER_SANITIZE_STRING);
        $item = new Item();
        $item->liste_id = $_SESSION['id_liste'];
        $item->nom = $nom;
        $item->descr = $descr;

        $uploadedFiles = $rq->getUploadedFiles();

        // handle single input with single file upload
        $uploadedFile = $uploadedFiles['image'];

        $hash = hash_file('md5',$uploadedFile->file);

        $res=explode('.',$uploadedFile->getClientFilename());
        $extension = end($res);
        
        $nomfichier = $hash.".".$extension;
        $uploadedFile->moveTo(__DIR__ . '/../../img/' . $nomfichier);

        $item->img = $nomfichier;
        $item->url = $url;
        $item->tarif = $prix;
        $item->save();
    }

    public function ajouterItem($rq,$rs,$args){
        if(!Authentication::isconnected()){
            $rs->getBody()->write('<h1>Vous devez être connecté pour accéder à cette page</h1>');
            return $rs;
        }
        $vueajouteritem = new VueAjouterItem($rq);
        $rs->getBody()->write($vueajouteritem->render());
        return $rs;
    }
    
}