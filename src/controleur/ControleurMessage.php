<?php

namespace wish\controleur;

use wish\models\Item;
use wish\models\Liste;
use wish\models\Message;
use wish\vues\VueListe;
use wish\vues\VueListes;
use wish\vues\VueMesListes;
use wish\vues\VueCreerListe;

class ControleurMessage {


    function creerMessage($rq,$rs,$args){
        if(!isset($_SESSION['user'])){
            return;
        }
        if(isset($rq->getParsedBody()['message'])){
            $message = new Message();
            $message->pseudo_id = $_SESSION['user']['id'];
            $message->liste_id = $args['id'];
            $message->message = filter_var($rq->getParsedBody()['message'], FILTER_SANITIZE_STRING);
            $message->save();
        }
        $path = $rq->getUri()->getBasePath() . "/liste/" .$args['id'];
        $rs = $rs->withRedirect($path);
        return $rs;
    }

}