<?php

namespace wish\vues;

class VueListe
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
        <body>
         <div class="content">
             <h1>
              Affiche d'une Liste d'Item ! 
             </h1>
            $content
         </div>
        </body><html>
END;
        return $html;
    }

    public function htmlListe(){
        $res ="";
        foreach ($this->model->items as $value) {
            $attributs=$value->getAttributes();
            $res .= "<p>";
            $res .= $attributs['nom']." ".$attributs['tarif']."€ ".$attributs['descr'];
            $res .= "</p>";
        }
        return $res;
    }
}
