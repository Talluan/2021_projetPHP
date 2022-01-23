<?php

namespace wish\vues;

class VueMesListes
{
    private $modelListe;
    private $modeleItem;
    private $id;

    function __construct($liste, $rq, $items, $identifiant)
    {
        $this->modelListe = $liste;
        $this->modeleItem = $items;
        $this->rq = $rq;
        $this->id = $identifiant;
    }

    public function render()
    {
        $content = $this->htmlListe();
        $html = new Vue($content, 'Listes', $this->rq);
        return $html->getHtml();
    }

    public function htmlListe()
    {
        $res = "";
        foreach ($this->modelListe as $liste) {
            $attributListe = $liste->getAttributes();
            if($attributListe['user_id'] == $this->id){
            $titre = $attributListe['titre'];
            $msg = $attributListe['description'] . " | " . $attributListe['expiration'];
            $res .= <<<END
                <ul class="list-unstyled">
                <li class="media">
END;
            

            $sourceliste = $this->rq->getUri()->getBasePath()."/liste/".$attributListe['no'];

            $res .= <<<END
            <div class="media-body">
                <a class="link-dark" href="$sourceliste"><h5 class="mt-0 mb-1">$titre.</h5></a>
                $msg
              </div>  
END;
            $num = $attributListe['no'];
            foreach ($this->modeleItem as $item) {
                $attributItem = $item->getAttributes();
                if ($attributItem['liste_id'] == $num) {
                    $img = $this->rq->getUri()->getBasePath() . "/img/" . $attributItem['img'];
                    $res .= <<<END
                    <img class="mr-3" src="$img" alt="image Item" width="100" height="100">
END;
                }
            }
        } //else {
            if(isset( $attributListe['cookieUser']) && $attributListe['cookieUser'] == $_COOKIE['WishListe2021AuChocolat']){
                $titre = $attributListe['titre'];
                $msg = $attributListe['description'] . " | " . $attributListe['expiration'];
                $res .= <<<END
                <ul class="list-unstyled">
                <li class="media">
END;
                $sourceliste = $this->rq->getUri()->getBasePath()."/liste/".$attributListe['no'];
                $res .= <<<END
                <div class="media-body">
                <a class="link-dark"    href="$sourceliste"><h5 class="mt-0 mb-1">$titre</h5></a>
                    $msg
                  </div>  
END;
                $num = $attributListe['no'];
                foreach ($this->modeleItem as $item) {
                    $attributItem = $item->getAttributes();
                    if ($attributItem['liste_id'] == $num) {
                        $img = $this->rq->getUri()->getBasePath() . "/img/" . $attributItem['img'];
                        $res .= <<<END
           <img class="mr-3" src="$img" alt="image Item" width="100" height="100">
END;
                    }
                }
            }
      //  }
        }
        $res .= "</li></ul>";
        return $res;
    }
}
