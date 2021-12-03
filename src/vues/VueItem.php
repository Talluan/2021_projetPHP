<?php

namespace wish\vues;

class VueItem{

    private $modele;

    public function __construct($mod){
        $this->modele = $mod;
    }

    public function render(){
        $content = $this->htmlUnItem();
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


    public function htmlUnItem(){
        $res ="";
        foreach ($this->modele->items as $value) {
            $res+="$value->nom.<br>";
        }
        return $res;
    }

}