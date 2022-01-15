<?php

namespace wish\vues;

class VueCreerListe
{
    private $model;
    function __construct($liste,$rq)
    {
        $this->model = $liste;
        $this->rq=$rq;
    }

    public function render()
    {
        $content = $this->creerListe();
        $html = new Vue($content, 'Création Liste',$this->rq);
        return $html->getHtml();
    }

    public function creerListe()
    {
        $host = $this->rq->getUri()->getBasePath();
        $res = <<<END

        <div class="container">
        <form action="$host/creerliste" method="POST">
        <div class="row">
          <div class="col">
            <div class="row">
                <label for="nomListe">Nom de la liste</label>
                <input id="nomListe" type="text" name="nom" class="form-control" placeholder="Nom Liste">
            </div>
            <div class="row">
                <label for="dateExpi">Date d'expiration de la liste</label>
                <input id="dateExpi" type="date" name="date" class="form-control" placeholder=Date d'expiration de la liste">
            </div>
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
