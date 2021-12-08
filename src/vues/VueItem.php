<?php

namespace wish\vues;

class VueItem
{

    private $modele;

    public function __construct($mod)
    {
        $this->modele = $mod;
    }

    public function render()
    {
        $content = $this->htmlUnItem();
        $html = <<<END
         <!DOCTYPE html> <html>
         <body> <h1> Affichage d'un Item ! </h1>
         <div class="content">
           $content
         </div>
        </body><html>
END;

        return $html;
    }


    public function htmlUnItem()
    {
        $res = "";
        foreach ($this->modele->items as $value) {
            $res += "$value->nom.<br>";
        }
        return $res;
    }
}
