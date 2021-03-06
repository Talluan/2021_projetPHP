<?php

namespace wish\vues;

use wish\controleur\Authentication;

class Vue
{
    private $html;

    /*
     *  $content String correspondant au information de la page à afficher
     *  $titre String le titre qui sera afficher en tant que Title sur la page web
     */
    public function __Construct($content, $titre, $rq)
    {
        $page = $this->setTemplate($content, $titre, $rq);
        $this->html = $page;
    }

    public function render() {
        $this->gethtml();
    }

    public function setTemplate($content, $titre, $rq) {
        $path = $rq->getUri()->getBasePath();
        $categories = <<<END
        <li class="nav-item d-flex">
            <a class="nav-link" href="$path/listes">Listes publiques</a>
        </li>
        <li class="nav-item d-flex">
            <a class="nav-link" href="$path/creerliste">Creer votre liste</a>
        </li>
        <li class="nav-item d-flex">
                    <a class="nav-link" href="$path/meslistes">Mes Listes</a>
                </li>
        <li class="nav-item d-flex">
        <a class="nav-link" href="$path/connexion">Connexion</a>
        </li>
    </ul>
END;
        if (Authentication::isConnected()) {
            $nom = $_SESSION['user']['pseudo'];
            $categories = <<<END
                <li class="nav-item d-flex">
                    <a class="nav-link" href="$path/listes">Listes publiques</a>
                </li>
                <li class="nav-item d-flex">
                    <a class="nav-link" href="$path/creerliste">Creer votre liste</a>
                </li>
                <li class="nav-item d-flex">
                    <a class="nav-link" href="$path/meslistes">Mes Listes</a>
                </li>
            </ul>

            <span class="navbar-brand">$nom</span>
            <a class="nav-link" href="$path/deco">Deconnexion</a>
END;
        }
        $temp = <<<END
         <!DOCTYPE html> <html>
          <head>
           <meta charset="utf-8">
           <meta name="viewport" content="width=device-width, initial-scale=1">
           <link rel="icon" href="$path/img/favicon.ico" />
           <title> $titre </title>
           <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" >
           <link href="$path/css/style.css" rel="stylesheet" >
          </head>
        <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	        <a class="navbar-brand" href="$path">
		        <img src="$path/img/favicon.ico" alt="" width="60" height="60">
	        </a>
	        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		        <span class="navbar-toggler-icon"></span>
	        </button>

	        <div class="collapse navbar-collapse" id="navbarSupportedContent">
		        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        $categories

	        </div>
        </nav>
          $content
         </body>
        <html>
END;
        return $temp;
    }

    public function getHtml()
    {
        return $this->html;
    }
}
