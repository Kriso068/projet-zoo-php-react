<?php

require_once './controllers/back/Securite.class.php';
require_once './models/back/familles.manager.php';


class FamillesController
{
    
    private $famillesManager;

    public function __construct()
    {
        $this->famillesManager = new FamillesManager();
    }

    public function visualisation()
    {
        if(Securite::verifAccessSession()) {

            $familles = $this->famillesManager->getFamilles();

            require_once 'views/famillesVisualisation.php';
        }else{
            throw new Exception('Vous n\'avez pas access à cette page !!!');
        }
    }

   


    public function modification()
    {
        if(Securite::verifAccessSession()) {

            $idFamille = (int)Securite::secureHtml($_POST['famille_id']);
            $libelle = (string)Securite::secureHtml($_POST['famille_libelle']);
            $description = (string)Securite::secureHtml($_POST['famille_description']);

            $this->famillesManager->updateFamille($idFamille, $libelle, $description);

            $_SESSION['alert'] = [
                'message' => 'La famille à été modifiée',
                'type' => 'alert-success'
            ];  
       
            header('Location:'. URL .'/back/familles/visualisation');
        }else{
            throw new Exception('Vous n\'avez pas access à cette page !!!');
        }
    }


    public function suppression()
    {
        if(Securite::verifAccessSession()) {

            $id = (int) Securite::secureHtml($_POST['famille_id']);

            if($this->famillesManager->compterAnimaux($id) > 0) {
                $_SESSION['alert'] = [
                    'message' => 'La famille n\'a pas été supprimée',
                    'type' => 'alert-danger'
                ];
            }else {

                $this->famillesManager->deleteDbFamilles($id);

                $_SESSION['alert'] = [
                    'message' => 'La famille est supprimée',
                    'type' => 'alert-success'
                ];      
            }
            header('Location:'. URL .'/back/familles/visualisation');
        }else{
            throw new Exception('Vous n\'avez pas access à cette page !!!');
        }
    }


    public function creationTemplate(){
        if(Securite::verifAccessSession()){
            require_once "views/creationFamille.php";
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }

    public function creationValidation(){
        if(Securite::verifAccessSession()){
            $libelle = Securite::secureHTML($_POST['famille_libelle']);
            $description = Securite::secureHTML($_POST['famille_description']);
            $idFamille = $this->famillesManager->createFamille($libelle,$description);

            $_SESSION['alert'] = [
                "message" => "La famille a bien été créée avec l'identifiant : ".$idFamille,
                "type" => "alert-success"
            ];

            header('Location: '.URL.'back/familles/visualisation');
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }
}