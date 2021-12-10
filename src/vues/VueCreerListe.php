<?php

namespace wish\vues;

class VueCreerListe
{
    private $model;
    function __construct($liste)
    {
        $this->model = $liste;
    }

    public function render()
    {
        $content = $this->creerListe();
        $html = new Vue($content, 'Création Liste');
        return $html->getHtml();
    }

    public function creerListe()
    {
        $host = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'];
        var_dump($_SERVER);
        $res = <<<END

        <div class="container">
        <form action="$host/projetphp/creerliste" method="POST">
        <div class="row">
          <div class="col">
          <input type="text" class="form-control" placeholder="Nom Liste">
          </div>
          <div class="form-group">
          <label for="exampleFormControlTextarea1">Description de la liste</label>
          <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        <button class="btn btn-primary" type="submit">créer</button>
     </div>
    </form>
</div>

        
END;

        return $res;
    }
}
