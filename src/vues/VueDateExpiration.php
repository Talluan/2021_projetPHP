<?php

namespace wish\vues;

class VueDateExpiration
{
    private $model;
    function __construct($rq)
    {
        $this->rq = $rq;
    }

    public function render()
    {
        $content = $this->ajouterDateExpiration();
        $html = new Vue($content, 'Modifier date', $this->rq);
        return $html->getHtml();
    }

    public function ajouterDateExpiration()
    {
        $uri = $this->rq->getUri()->getBasePath() . "/ajouterDateExpiration";
        $res = <<<END

        <div class="container">
            <form action="$uri" method="post" enctype="multipart/form-data">
                <p>
                    <label>Date d'expiration : </label><br/>
                    <input type="date" name="date"/><br>
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
