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
           <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
          </head>
         <body> <h1> Robin = Le Très Gros Furry </h1>
          $content
         </body>
        <html>
END;
    }

    public function getHtml(){
        return $this->html;
    }
}