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
        $res = $this->modele->getAttribute('id').'<br>';
        $res .= $this->modele->getAttribute('liste_id').'<br>';
        $res .= $this->modele->getAttribute('descr').'<br>';
        $res .= $this->modele->getAttribute('img').'<br>';
        $res .= $this->modele->getAttribute('url').'<br>';
        $res .= $this->modele->getAttribute('tarif').'<br>';
        return $res;
    }
}
