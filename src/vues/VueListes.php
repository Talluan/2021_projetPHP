<?php

namespace wish\vues;

class VueListes
{
    private $modelListe;
    private $modeleItem;

    function __construct($liste, $rq, $items)
    {
        $this->modelListe = $liste;
        $this->modeleItem = $items;
        $this->rq = $rq;
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
            $titre = $attributListe['titre'];
            $msg = $attributListe['description'] . " | " . $attributListe['expiration'];
            $listepath = $this->rq->getUri()->getBasePath() . "/liste/" . $attributListe['no'];
            $res .= <<<END
            <ul class="list-unstyled">
            <li class="media">
END;
            $res .= <<<END
            <div class="media-body">
                <a class="link-dark"    href="$listepath"><h5 class="mt-0 mb-1">$titre</h5></a>
                $msg
              </div>  
END;
            $num = $attributListe['no'];
            foreach ($this->modeleItem as $item) {
                $attributItem = $item->getAttributes();
                if ($attributItem['liste_id'] == $num) {
                    $img = $this->rq->getUri()->getBasePath() . "/img/" . $attributItem['img'];
                    $itempath = '"'.$this->rq->getUri()->getBasePath() . "/item/" . $attributItem['id'].'"';
                    $res .= <<<END
       <a href=$itempath><img class="mr-3 bg-image hover-overlay ripple shadow-1-strong rounded"
       data-mdb-ripple-color="light" src="$img" alt="image Item" width="100" height="100"><a>
END;
                }
            }
        }
        $res .= "</li></ul>";
        return $res;
    }
}
