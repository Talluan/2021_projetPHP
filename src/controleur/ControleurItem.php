<?php

namespace wish\controleur;

use wish\models\Item;
use wish\models\Reservation;
use wish\vues\VueItem;
use wish\controleur\Authentication;
use wish\vues\VueAjouterItem;
use wish\models\Liste;

class ControleurItem
{

    /*
    *fonction qui renvoie l'item demande grace a son id dans l'URL
    *@return le code html corespondant a la vue
    */
    public static function getItem($rq,$rs,$args) {
        $id_item = $args['id'];
        $item =  Item::find($id_item);
        $reserv = $item->reservation()->first();
        $vueitem = new VueItem($item,$rq);
        if (isset($reserv)) {
            $user = $reserv->user()->first();
            $vueitem = new VueItem($item,$rq, $user);
        }
        $rs->getBody()->write($vueitem->render());
        return $rs;
    }

    public function traiterItem($rq, $rs, $args)
    {
        if (!isset($_SESSION['id_liste'])) {
            $rs->getBody()->write("Vous n'avez pas acces a cette page");
            return $rs;
        }
        $l=null;

        $idListe=$_SESSION['id_liste'];

        if($idListe<10000){ // pas le choix avec le systeme de mathmaille
            $l=Liste::find($idListe);
            //si on y accede par un idList on doit verifier qu'il est admin
            if($_SESSION['user']['auth_lvl']!=3){
                //sinon on regarde si c'est sa propre liste
                if($l->user_id != $_SESSION['user']['id']){
                    //si aucune des conditions n'est rempli on ne fait rien
                    $rs->getBody()->write("ERREUR PERMISSION");
                    return $rs;
                }
            }
        }else{
            $l=Liste::where("tokenEdition",$args['token'])->first();
        }
        $parsed = $rq->getParsedBody();
        $nom = filter_var($parsed['nom'], FILTER_SANITIZE_STRING);
        $descr = filter_var($parsed['description'], FILTER_SANITIZE_STRING);
        $prix = filter_var($parsed['prix'], FILTER_SANITIZE_STRING);
        $url = filter_var($parsed['url'], FILTER_SANITIZE_STRING);
        $item = new Item();
        $item->liste_id = $l->no;
        $item->nom = $nom;
        $item->descr = $descr;

        $uploadedFiles = $rq->getUploadedFiles();
        if ($uploadedFiles['image']->getError() === UPLOAD_ERR_OK) {
            $uploadedFile = $uploadedFiles['image'];

            $hash = hash_file('md5', $uploadedFile->file);

            $res = explode('.', $uploadedFile->getClientFilename());
            $extension = end($res);

            $nomfichier = $hash . "." . $extension;
            $uploadedFile->moveTo(__DIR__ . '/../../img/' . $nomfichier);

            $item->img = $nomfichier;
        }else{
            $item->img = "gift.jpg";
        }


        $item->url = $url;
        $item->tarif = $prix;
        $item->save();
        return $rs->withRedirect($rq->getUri()->getBasePath() . '/liste/' . $_SESSION['id_liste']);
    }

    public function ajouterItem($rq, $rs, $args)
    {
        if (!Authentication::isconnected()) {
            $rs->getBody()->write('<h1>Vous devez être connecté pour accéder à cette page</h1>');
            return $rs;
        }
        $vueajouteritem = new VueAjouterItem($rq);
        $rs->getBody()->write($vueajouteritem->render());
        return $rs;
    }


    public function reserverItem($rq,$rs,$args) {
        if (!Authentication::isconnected()) {
            $rs->getBody()->write('<h1>Vous devez être connecté pour accéder à cette page</h1>');
            return $rs;
        }
        $id_item = $args['id'];
        $item =  Item::find($id_item);
        $r = Reservation::where('item_id', $item)->first();
        if (isset($r)) {
            $rs->getBody()->write('<h1>Cet item est déjà réservé</h1>');
            return $rs;
        }
        $reserv = new Reservation();
        if (isset($rq->getParsedBody()['message'])) {
            $reserv->message = filter_var($rq->getParsedBody()['message'], FILTER_SANITIZE_STRING);
        }
        $reserv->item_id = $item->id;
        $reserv->user_id = $_SESSION['user']['id'];
        $reserv->save();
        return ControleurItem::getItem($rq, $rs, $args);

    }

    public function annulerReservation($rq, $rs, $args) {
        if (!Authentication::isconnected()) {
            $rs->getBody()->write('<h1>Vous devez être connecté pour accéder à cette page</h1>');
            return $rs;
        }
        $id_item = $args['id'];
        $item =  Item::find($id_item);
        $r = $item->reservation;
        if (!isset($r)) {
            var_dump($r);
            $rs->getBody()->write('<h1>Cet item n\'est pas encore réservé !</h1>');
            return $rs;
        }
        else {
            $r->delete();
            $r->refresh();
            // On redirige l'utilisateur vers la page de l'item
            $path = $rq->getUri()->getBasePath() . "/item/$id_item";
            $rs = $rs->withRedirect($path);
            return $rs;
        }
    }
}
