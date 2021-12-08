<?php 

namespace wish\vues;

class Vue
{
public $html;

    public function Vue($content){
        $this->html= <<<END
         <!DOCTYPE html> <html>
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