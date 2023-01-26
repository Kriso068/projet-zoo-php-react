<?php

require_once './controllers/back/Securite.class.php';
require_once './models/back/familles.manager.php';


class FamillesController
{
    /**
     * Summary of famillesManager
     * @var FamillesManager
     */
    private $famillesManager;


    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->famillesManager = new FamillesManager();
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

            $familles = $this->famillesManager->getFamilles();

            require_once 'views/famillesVisualisation.php';
        }else{
            throw new Exception('Vous n\'avez pas access à cette page !!!');
        }
    }


    /**
     * Summary of modification
     * @throws Exception
     * @return void
     */
    public function modification()
    {
        //vérification si l'utilisateur à access à cette page grace à la fonction qui est dans './controllers/back/Securite.class.php';
        if(Securite::verifAccessSession()) {

            //on sécurise la donnée récupéré garce à la fonction secrureHtml qui est dans './controllers/back/Securite.class.php';
            $idFamille = (int)Securite::secureHtml($_POST['famille_id']);
            $libelle = (string)Securite::secureHtml($_POST['famille_libelle']);
            $description = (string)Securite::secureHtml($_POST['famille_description']);

            //on appel la fonction du manager pour faire l'update avec les données récupérées
            $this->famillesManager->updateFamille($idFamille, $libelle, $description);

            //grace à la session nous générons un message
            $_SESSION['alert'] = [
                'message' => 'La famille à été modifiée',
                'type' => 'alert-success'
            ];  
       
            //nous renvoyons sur la page 'back/familles/visualisation'
            header('Location:'. URL .'/back/familles/visualisation');
        }else{
            throw new Exception('Vous n\'avez pas access à cette page !!!');
        }
    }

    /**
     * Summary of suppression
     * @throws Exception
     * @return void
     */
    public function suppression()
    {
       //nous renvoyons sur la page 'back/familles/visualisation'
        if(Securite::verifAccessSession()) {

            //on sécurise la donnée récupéré garce à la fonction secrureHtml qui est dans './controllers/back/Securite.class.php';
            $id = (int) Securite::secureHtml($_POST['famille_id']);


            //on regarde si un animal est lié a une famille si c'est vrai alors on met un message et on ne supprime pas la famille
            if($this->famillesManager->compterAnimaux($id) > 0) {
                

                //grace à la session nous générons un message 
                $_SESSION['alert'] = [
                    'message' => 'La famille n\'a pas été supprimée',
                    'type' => 'alert-danger'
                ];

                //sinon nous supprimons la famille
            }else {

                //nous cherchons la fonction qui servent à supprimer la famille dans la BDD
                $this->famillesManager->deleteDbFamilles($id);


                $_SESSION['alert'] = [
                    'message' => 'La famille est supprimée',
                    'type' => 'alert-success'
                ];      
            }

            //nous renvoyons sur la page 'back/familles/visualisation'
            header('Location:'. URL .'/back/familles/visualisation');
        }else{
            throw new Exception('Vous n\'avez pas access à cette page !!!');
        }
    }

    /**
     * Summary of creationTemplate
     * @throws Exception
     * @return void
     * sert à nous envoyer sur la vue du formulaire pour creer une famille
     */
    public function creationTemplate()
    {
        //vérification si l'utilisateur à access à cette page grace à la fonction qui est dans './controllers/back/Securite.class.php';
        if(Securite::verifAccessSession()){

            require_once "views/creationFamille.php";
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }


    /**
     * Summary of creationValidation
     * @throws Exception
     * @return void
     * sert à récupérer les données du formulaire et créer une famille
     */
    public function creationValidation(){

        //vérification si l'utilisateur à access à cette page grace à la fonction qui est dans './controllers/back/Securite.class.php';
        if(Securite::verifAccessSession()){

            //on sécurise la donnée récupéré garce à la fonction secrureHtml qui est dans './controllers/back/Securite.class.php';
            $libelle = Securite::secureHTML($_POST['famille_libelle']);
            $description = Securite::secureHTML($_POST['famille_description']);

            //on appel la fonction du manager pour faire la creation avec les données récupérées
            $idFamille = $this->famillesManager->createFamille($libelle,$description);

            //grace à la session nous générons un message  
            $_SESSION['alert'] = [
                "message" => "La famille a bien été créée avec l'identifiant : ".$idFamille,
                "type" => "alert-success"
            ];

            //nous renvoyons sur la page 'back/familles/visualisation'
            header('Location: '.URL.'back/familles/visualisation');
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }
}