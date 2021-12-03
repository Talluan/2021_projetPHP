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
              Affiche d'un Item ! 
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
            $res+="$value->nom.<br>";
        }
        return $res;
    }
}
