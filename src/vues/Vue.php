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
           <meta name="viewport" content="width=device-width, initial-scale=1">
           <link rel="icon" href="img/favicon.ico" />
           <title> $titre </title>
           <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" >
          </head>
         <body>
          $content
         </body>
        <html>
END;
    }

    public function getHtml(){
        return $this->html;
    }
}