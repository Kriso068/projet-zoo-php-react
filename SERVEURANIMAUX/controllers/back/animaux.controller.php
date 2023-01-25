<?php

require_once './controllers/back/Securite.class.php';
require_once './models/back/animaux.manager.php';
require_once './models/back/familles.manager.php';
require_once './models/back/continents.manager.php';
require_once './controllers/back/utile.php';




class AnimauxController
{
    
    private $animauxManager;

    public function __construct()
    {
        $this->animauxManager = new AnimauxManager();
    }

    public function visualisation()
    {
        if(Securite::verifAccessSession()) {

            $animaux = $this->animauxManager->getAnimaux();

            require_once 'views/animauxVisualisation.php';
        }else{
            throw new Exception('Vous n\'avez pas access à cette page !!!');
        }
    }

   


    public function modification($idAnimal)
    {
        if(Securite::verifAccessSession()) {

            $familleManager = new FamillesManager();

            $familles = $familleManager->getFamilles();

            $continentsManager = new ContinentsManager();

            $continents = $continentsManager->getContinents();


            $lignesAnimal = $this->animauxManager->getAnimal((int)Securite::secureHtml($idAnimal));

            $tabContinents = [];

            foreach($lignesAnimal as $continent) {
                $tabContinents[] = $continent['continent_id'];
            }

            $animal = array_slice($lignesAnimal[0], 0, 5);

           
            require_once "views/animalModification.php";
       

        }else{
            throw new Exception('Vous n\'avez pas access à cette page !!!');
        }
    }

    public function modificationValidation(){
        if(Securite::verifAccessSession()){
            $idAnimal = Securite::secureHTML($_POST['animal_id']);
            $nom = Securite::secureHTML($_POST['animal_nom']);
            $description = Securite::secureHTML($_POST['animal_description']);
            $image = $this->animauxManager->getImageAnimal($idAnimal);

            if($_FILES['image']['size'] > 0) {
                unlink('public/images/'.$image);
                $repertoire = "public/images/";
                $image = ajoutImage($_FILES['image'], $repertoire);
            }
           
            $idFamille = (int) Securite::secureHTML($_POST['famille_id']);

            $this->animauxManager->updateAnimal($idAnimal,$nom,$description,$image,$idFamille);
            
            $continents = [
                1 => !empty($_POST['continent-1']),
                2 => !empty($_POST['continent-2']),
                3 => !empty($_POST['continent-3']),
                4 => !empty($_POST['continent-4']),
                5 => !empty($_POST['continent-5']),
            ];

            $continentsManager = new ContinentsManager;

            foreach ($continents as $key => $continent) {
                //continent coché et non présent en BD
                if($continent && !$continentsManager->verificationExisteAnimalContinent($idAnimal,$key)){
                    $continentsManager->addContinentAnimal($idAnimal,$key);
                }

                //continent non coché et présent en BD
                if(!$continent && $continentsManager->verificationExisteAnimalContinent($idAnimal,$key)){
                    $continentsManager->deleteDBContinentAnimal($idAnimal,$key);
                }
            }

            $_SESSION['alert'] = [
                "message" => "L'animal a bien été modifié",
                "type" => "alert-success"
            ];
            header('Location: '.URL.'back/animaux/visualisation');
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }

    public function suppression()
    {
        if(Securite::verifAccessSession()) {

            $id = (int) Securite::secureHtml($_POST['animal_id']);
            $image = $this->animauxManager->getImageAnimal($id);
            unlink('public/images/' . $image);

            $this->animauxManager->deleteDbanimalContinent($id);
            $this->animauxManager->deleteDbAnimal($id);

            $_SESSION['alert'] = [
                'message' => 'L\'animal est supprimé',
                'type' => 'alert-success'
            ];      
            
            header('Location:'. URL .'/back/animaux/visualisation');
        }else{
            throw new Exception('Vous n\'avez pas access à cette page !!!');
        }
    }


    public function creationTemplate(){
        if(Securite::verifAccessSession()){

            $familleManager = new FamillesManager();

            $familles = $familleManager->getFamilles();

            $continentsManager = new ContinentsManager();

            $continents = $continentsManager->getContinents();

            require_once "views/creationAnimal.php";
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }

    public function creationValidation(){
        if(Securite::verifAccessSession()){
            $nom = Securite::secureHTML($_POST['animal_nom']);
            $description = Securite::secureHTML($_POST['animal_description']);
            $image = '';

            if($_FILES['image']['size'] > 0){
                $repertoire = "public/images/";
                $image = ajoutImage($_FILES['image'],$repertoire);
            }
            $idFamille = (int)Securite::secureHTML($_POST['famille_id']);


            $idAnimal = $this->animauxManager->createanimal($nom, $description, $image, $idFamille);

            $continentsManager = new ContinentsManager();

            if(!empty($_POST['continent-1'])){
                $continentsManager->addContinentAnimal($idAnimal, 1);
            }
            if(!empty($_POST['continent-2'])){
                $continentsManager->addContinentAnimal($idAnimal, 2);
            }
            if(!empty($_POST['continent-3'])){
                $continentsManager->addContinentAnimal($idAnimal, 3);
            }
            if(!empty($_POST['continent-4'])){
                $continentsManager->addContinentAnimal($idAnimal, 4);
            }
            if(!empty($_POST['continent-5'])){
                $continentsManager->addContinentAnimal($idAnimal, 5);
            }


            $_SESSION['alert'] = [
                "message" => "L'animal à bien été créé avec l'identifiant : ".$idAnimal,
                "type" => "alert-success"
            ];

            header('Location: '.URL.'back/animaux/visualisation');
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }
}