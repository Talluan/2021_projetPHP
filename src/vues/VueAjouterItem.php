<?php

namespace wish\vues;

class VueAjouterItem
{
    private $model;
    function __construct($rq)
    {
        $this->rq = $rq;
    }

    public function render()
    {
        $content = $this->ajouterItem();
        $html = new Vue($content, 'Ajouter item', $this->rq);
        return $html->getHtml();
    }

    public function ajouterItem()
    {
        $tokenedit=$this->rq->getAttribute('token');
        $uri = $this->rq->getUri()->getBasePath()."/ajouteritem/$tokenedit";
        $res = <<<END

        <div class="container">
        <form action="$uri" method="post" enctype="multipart/form-data">
    <!-- upload of a single file -->
    <p>
        <label>Image : </label><br/>
        <input type="file" name="image"/><br>
        <input required type="text" name="nom" placeholder="nom item.."/><br>
        <input type="number" name="prix" placeholder="prix item.."/><br>
        <input type="text" name="url" placeholder="url item.."/><br>
        <textarea required name="description" placeholder="description.."></textarea>
    </p>
    <p>
        <input type="submit"/>
    </p>
</form>
</div>

        
END;

        return $res;
    }
}
