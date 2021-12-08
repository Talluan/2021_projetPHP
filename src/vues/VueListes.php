<?php

namespace wish\vues;

class VueListes
{
    private $model;
    function __construct($liste)
    {
        $this->model = $liste;
    }

    public function render()
    {
        $content = $this->htmlListe();
        $html = <<<END
        <!DOCTYPE html> <html>
        <head>
            <meta charset="utf-8">
            <title>Listes</title>
        </head>
        <body>
         <div class="content">
             <h1>
              Affichage de toutes les listes
             </h1>
            $content
         </div>
        </body><html>
END;
        return $html;
    }

    public function htmlListe()
    {
        $res = "";
        foreach ($this->model as $liste) {
            $attributs = $liste->getAttributes();
            $res .= "<div class='liste'>";
            $res .= "<h2>" . $attributs['titre'] . "</h2>";
            $res .= "<p>" . $attributs['description'] . "</p>";
            $res .= "<p> date d'expiration : " . $attributs['expiration'] . "</p>";
        }

        return $res;
    }
}
