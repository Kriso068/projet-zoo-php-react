<?php

require_once './controllers/back/Securite.class.php';
require_once './models/back/animaux.manager.php';
require_once './models/back/familles.manager.php';
require_once './models/back/continents.manager.php';
require_once './controllers/back/utile.php';




class AnimauxController
{
    /**
     * Summary of animauxManager
     * @var AnimauxManager
     */
    private $animauxManager;


    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->animauxManager = new AnimauxManager();
    }


    /**
     * Summary of visualisation
     * @throws Exception
     * @return void
     * nous envoi vers la vue 
     */
    public function visualisation()
    {
        if(Securite::verifAccessSession()) {

            $animaux = $this->animauxManager->getAnimaux();

            require_once 'views/animauxVisualisation.php';
        }else{
            throw new Exception('Vous n\'avez pas access à cette page !!!');
        }
    }


    /**
     * Summary of modification
     * @param int $idAnimal
     * @throws Exception
     * @return void
     * modification d'un amimal grace à sont ID
     */
    public function modification($idAnimal)
    {

        //vérification si l'utilisateur à access à cette page grace à la fonction qui est dans './controllers/back/Securite.class.php';
        if(Securite::verifAccessSession()) {

            //on récupère les managers dont nous avons besoin
            $familleManager = new FamillesManager();
            $continentsManager = new ContinentsManager();

            //on cherche les fonctions des managers
            $familles = $familleManager->getFamilles();
            $continents = $continentsManager->getContinents();


            //on sécurise la donnée récupéré garce à la fonction secrureHtml qui est dans './controllers/back/Securite.class.php';
            $lignesAnimal = $this->animauxManager->getAnimal((int)Securite::secureHtml($idAnimal));

            //on créer un tableau vide
            $tabContinents = [];

            //on parcour le tableau récupéré depuis la BDD
            foreach($lignesAnimal as $continent) {

                //on récupère le continent_id 
                $tabContinents[] = $continent['continent_id'];
            }

            //on découpe le tableau à l'indice 0 récupéré depuis la BDD de 0 à 5 (colonne)
            $animal = array_slice($lignesAnimal[0], 0, 5);

           
            require_once "views/animalModification.php";
       

        }else{
            throw new Exception('Vous n\'avez pas access à cette page !!!');
        }
    }


    /**
     * Summary of modificationValidation
     * @throws Exception
     * @return void
     * fonction servant à la modification d'un animal
     */
    public function modificationValidation(){

        //vérification si l'utilisateur à access à cette page grace à la fonction qui est dans './controllers/back/Securite.class.php';
        if(Securite::verifAccessSession()){

            //on sécurise la donnée récupéré garce à la fonction secrureHtml qui est dans './controllers/back/Securite.class.php';
            $idAnimal = Securite::secureHTML($_POST['animal_id']);
            $nom = Securite::secureHTML($_POST['animal_nom']);
            $description = Securite::secureHTML($_POST['animal_description']);

            //on récupère l'image qui est dans la BDD 
            $image = $this->animauxManager->getImageAnimal($idAnimal);


            //si la taille dépasse 0 alors ca veut dire que l'on veut modifier l'image alor on procède au future upload
            if($_FILES['image']['size'] > 0) {
                //unlink sert à supprimer l'image de public/images
                unlink('public/images/'.$image);
                $repertoire = "public/images/";
                $image = ajoutImage($_FILES['image'], $repertoire);
            }
           
            //on sécurise la donnée récupéré garce à la fonction secrureHtml qui est dans './controllers/back/Securite.class.php';
            $idFamille = (int) Securite::secureHTML($_POST['famille_id']);

            //on appel la fonction du manager pour faire l'update avec les données récupérées
            $this->animauxManager->updateAnimal($idAnimal,$nom,$description,$image,$idFamille);
            
            //on fait un tableau des continent grace aux checkbox cochées
            $continents = [
                1 => !empty($_POST['continent-1']),
                2 => !empty($_POST['continent-2']),
                3 => !empty($_POST['continent-3']),
                4 => !empty($_POST['continent-4']),
                5 => !empty($_POST['continent-5']),
            ];

             //on récupère le manager dont nous avons besoin
            $continentsManager = new ContinentsManager;

            //on parcourt le tableau des continents
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

            //grace à la session nous générons un message
            $_SESSION['alert'] = [
                "message" => "L'animal a bien été modifié",
                "type" => "alert-success"
            ];

            //nous renvoyons sur la page 'back/animaux/visualisation'
            header('Location: '.URL.'back/animaux/visualisation');
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }

    /**
     * Summary of suppression
     * @throws Exception
     * @return void
     * supprimer un amimal
     */
    public function suppression()
    {
        //vérification si l'utilisateur à access à cette page grace à la fonction qui est dans './controllers/back/Securite.class.php';
        if(Securite::verifAccessSession()) {

            //on sécurise la donnée récupéré garce à la fonction secrureHtml qui est dans './controllers/back/Securite.class.php';
            $id = (int) Securite::secureHtml($_POST['animal_id']);

            //on récupère l'image qui est dans la BDD 
            $image = $this->animauxManager->getImageAnimal($id);
            //unlink sert à supprimer l'image de public/images
            unlink('public/images/' . $image);


            //nous cherchons les deux fonction qui servent à supprimer l'animal dans la BDD
            $this->animauxManager->deleteDbanimalContinent($id);
            $this->animauxManager->deleteDbAnimal($id);


            //grace à la session nous générons un message
            $_SESSION['alert'] = [
                'message' => 'L\'animal est supprimé',
                'type' => 'alert-success'
            ];      
            
            //nous renvoyons sur la page 'back/animaux/visualisation'
            header('Location:'. URL .'/back/animaux/visualisation');
        }else{
            throw new Exception('Vous n\'avez pas access à cette page !!!');
        }
    }


    /**
     * Summary of creationTemplate
     * @throws Exception
     * @return void
     * sert à nous envoyer sur la vue du formulaire pour creer un animal
     */
    public function creationTemplate(){

        //vérification si l'utilisateur à access à cette page grace à la fonction qui est dans './controllers/back/Securite.class.php';
        if(Securite::verifAccessSession()){

            //on récupère les managers dont nous avons besoin
            $familleManager = new FamillesManager();
            $continentsManager = new ContinentsManager();

            //on cherche les fonctions des managers
            $familles = $familleManager->getFamilles();
            $continents = $continentsManager->getContinents();


            require_once "views/creationAnimal.php";
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }


    /**
     * Summary of creationValidation
     * @throws Exception
     * @return void
     * sert à récupérer les données du formulaire et créer un animal
     */
    public function creationValidation(){

        //vérification si l'utilisateur à access à cette page grace à la fonction qui est dans './controllers/back/Securite.class.php';
        if(Securite::verifAccessSession()){

            //on sécurise la donnée récupéré garce à la fonction secrureHtml qui est dans './controllers/back/Securite.class.php';
            $nom = Securite::secureHTML($_POST['animal_nom']);
            $description = Securite::secureHTML($_POST['animal_description']);
            $image = '';
            $idFamille = (int)Securite::secureHTML($_POST['famille_id']);

           //si la taille dépasse 0 alors ca veut dire que l'on veut importer l'image alor on procède au future upload
           if($_FILES['image']['size'] > 0) {
                $repertoire = "public/images/";
                $image = ajoutImage($_FILES['image'],$repertoire);
            }
            
            //on appel la fonction du manager pour faire la creation avec les données récupérées
            $idAnimal = $this->animauxManager->createAnimal($nom, $description, $image, $idFamille);


            //on récupère le manager dont nous avons besoin
            $continentsManager = new ContinentsManager();


            //on va controler si les checkbos sont cochés
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

            //grace à la session nous générons un message       
            $_SESSION['alert'] = [
                "message" => "L'animal à bien été créé avec l'identifiant : ".$idAnimal,
                "type" => "alert-success"
            ];

            //nous renvoyons sur la page 'back/animaux/visualisation'
            header('Location: '.URL.'back/animaux/visualisation');
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }
}