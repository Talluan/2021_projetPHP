<?php 

namespace wish\vues;

class Vue
{
private $html;

    /*
     *  $content String correspondant au information de la page à afficher
     *  $titre String le titre qui sera afficher en tant que Title sur la page web
     */
    public function __Construct($content,$titre){
        $this->html= <<<END
         <!DOCTYPE html> <html>
          <head>
           <meta charset="utf-8">
           <title> $titre </title>
          </head>
         <body> <h1> Robin = Furry </h1>
          $content
         </body>
        <html>
END;
    }

    public function getHtml(){
        return $this->html;
    }
}