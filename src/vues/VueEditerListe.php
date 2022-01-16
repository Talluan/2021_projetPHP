<?php

namespace wish\vues;

class VueEditerListe
{
    private $model;
    function __construct($liste,$rq)
    {
        $this->model = $liste;
        $this->rq=$rq;
    }

    public function render()
    {
        $content = $this->editerListe();
        $html = new Vue($content, 'Edition Liste',$this->rq);
        return $html->getHtml();
    }

    public function editerListe()
    {   
        $host = $this->rq->getUri()->getBasePath();
        $liste_id = $this->model->getAttributes()['no'];
        $old_titre = $this->model->getAttributes()['titre'];
        $old_description = $this->model->getAttributes()['description'];
        $old_expiration = $this->model->getAttributes()['expiration'];
        $res = <<<HTML

        <div class="container">
        <form action="$host/modifierListe/$liste_id" method="POST">
        <div class="row">
          <div class="col">
            <div class="row">
                <label for="nomListe">Nom de la liste</label>
                <input id="nomListe" type="text" name="nom" class="form-control" value="$old_titre">
            </div>
            <div class="row">
                <label for="dateExpi">Date d'expiration de la liste</label>
                <input id="dateExpi" type="date" name="date" class="form-control" value=$old_expiration">
            </div>
          </div>
          <div class="col">
          <div class="form-group">
            <label for="descriptionListe">Description de la liste</label>
            <input type="textarea" name="descr" class="form-control" value=$old_description id="descriptionListe" rows="3">
          </div>
        </div>
        <hr>
        <button class="btn btn-primary" type="submit">Editer</button>
     </div>
    </form>
</div>

        
HTML;

        return $res;
    }
}
