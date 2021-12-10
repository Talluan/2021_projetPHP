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
        $res = <<<END

        <div class="container">
        <form>
        <div class="row">
          <div class="col">
          <input type="text" class="form-control" placeholder="Nom Liste">
          </div>
          <div class="form-group">
          <label for="exampleFormControlTextarea1">Description de la liste</label>
          <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        <button type="button" class="btn btn-primary">créer</button>
     </div>
    </form>
</div>

        
END;

        return $res;
    }
}
