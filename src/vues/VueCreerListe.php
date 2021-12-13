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
        $res = <<<END

        <div class="container">
        <form action="$host/projetphp/creerliste" method="POST">
        <div class="row">
          <div class="col">
          <label for="nomListe">Nom de la liste</label>
          <input id="nomListe" type="text" name="nom" class="form-control" placeholder="Nom Liste">
          </div>
          <div class="col">
          <div class="form-group">
          <label for="descriptionListe">Description de la liste</label>
          <textarea name="descr" class="form-control" id="descriptionListe" rows="3"></textarea>
          </div>
        </div>
        <hr>
        <button class="btn btn-primary" type="submit">créer</button>
     </div>
    </form>
</div>

        
END;

        return $res;
    }
}
