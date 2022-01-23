<?php

namespace wish\vues;

use wish\controleur\Authentication;

class VueConnexion
{
    private $error;

    function __construct($rq, $error = NULL)
    {
        $this->rq = $rq;
        $this->error = $error;
    }

    public function render()
    {
        // Authentication::freeProfile();
        // if (isset($_SESSION['user'])) {
            
        // }
        // else {
            $content = $this->creerVueConnexion();
            if (isset($this->error)) {
                $content .= $this->addError();
            }
            $html = new Vue($content, 'Connexion', $this->rq);
            return $html->getHtml();
        // }
    }

    public function creerVueConnexion()
    {
        $host = $this->rq->getUri()->getBasePath();
        $res = <<<END
    <div class="container">
        <div class="row">
            <div class="col-6 p-3">
                <form action="$host/connexion/connex" method="POST">
                    <h3> Se connecter </h3>
                    <div class="row">
                        <div class="col">
                            <label for="connecnomListe">Pseudo</label>
                            <input id="connecnomListe" type="text" name="pseudo" class="form-control" placeholder="Pseudonyme">
                        </div>
                        <div class="col">
                            <label for="connecmotDePasse">Mot de Passe</label>
                            <input id="connecmotDePasse" type="password" name="passw" class="form-control" placeholder="Mot De Passe">
                        </div>
                    </div>
                    <hr>
                    <div class="row justify-content-md-center">
                        <div class="col-md-auto">
                            <button class="btn btn-primary btn-lg" type="submit">Se connecter</button>
                        </div>        
                    </div>
                </form>
            </div>
            <div class="col-6 p-3">
                <form action="$host/connexion/crea" method="POST">
                    <h3> Créer un compte </h3>
                    <div class="row">
                        <div class="col">
                            <label for="nomListe">Pseudo</label>
                            <input id="nomListe" type="text" name="pseudo" class="form-control" placeholder="Pseudonyme">
                        </div>
                        <div class="col">
                            <label for="motDePasse">Mot de Passe</label>
                            <input id="motDePasse" type="password" name="passw" class="form-control" placeholder="Mot De Passe">
                        </div>
                    </div>
                    <hr>
                    <div class="row justify-content-md-center">
                        <div class="col-md-auto">
                            <button class="btn btn-primary btn-lg" type="submit">Créer</button>
                        </div>        
                    </div>
                </form>
            </div>
        </div>
    </div>    
END;

        return $res;
    }

    /**
     * Fonction qui permet l'affichage des erreurs
     */
    public function addError()
    {
        if ($this->error == 1) {
            $res = <<<END
            <hr>
            <div class="container">
                <div class="alert alert-warning" role="alert">
                    Il semblerait que votre mot de passe ou votre pseudo comporte une erreur. Veuillez les vérifier.
                </div>
            </div>
END;
        } else if ($this->error == 2) {
            $res = <<<END
            <hr>
            <div class="container">
                <div class="alert alert-warning" role="alert">
                    Il semblerait que votre mot de passe ne soit pas assez long ! Il doit faire plus de 12 caractères.
                </div>
            </div>
END;
        } else if ($this->error == 3) {
            $res = <<<END
            <hr>
            <div class="container">
                <div class="alert alert-warning" role="alert">
                    Mot de passe incorrect.
                </div>
            </div>
END;
        } else if ($this->error == 4) {
            $res = <<<END
            <hr>
            <div class="container">
                <div class="alert alert-warning" role="alert">
                    Pas d'identifiant correspondant.
                </div>
            </div>
END;
        } else if ($this->error == 5) {
            $res = <<<END
            <hr>
            <div class="container">
                <div class="alert alert-warning" role="alert">
                    Identifiant déjà utilisé ! Veuillez en choisir un autre.
                </div>
            </div>
END;
        } else {
            $res = <<<END
            <hr>
            <div class="container">
                <div class="alert alert-warning" role="alert">
                    Connecté !
                </div>
            </div>
END;
        }
        return $res;
    }



    public function creerVueConnecte() {
        $host = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'];
        $res = <<<END
        <div class="container">
        
        </div>
END;
        return $res;
    }

}
