<?php

require_once 'models/front/API.manager.php';
require_once 'models/Model.php';


class APIController
{

    /**
     * Summary of APIManager
     * @var mixed
     */
    private $apiManager;



    public function __construct()
    {
        $this->apiManager = new APIManager();
    }


    /**
     * Summary of getAnimaux
     * @return void
     */
    public function getAnimaux($idFamille, $idContinent)
    {
        $animaux = $this->apiManager->getDBAnimaux($idFamille, $idContinent);

        //on à access à Model et à ses fonctions 
        Model::sendJSON($this->formatDataLignesAnimaux($animaux));
        
    }

    /**
     * Summary of getAnimal
     * @param mixed $idAnimal
     * @return void
     */
    public function getAnimal($idAnimal)
    {
        $lignesAnimal = $this->apiManager->getDBAnimal($idAnimal);

         //on à access à Model et à ses fonctions 
         Model::sendJSON($this->formatDataLignesAnimaux($lignesAnimal));

        
    }

    private function formatDataLignesAnimaux($lignes)
    {
        $tab = [];

        foreach($lignes as $ligne) {

            //si $ligne['animal_id'] n'hesiste pas alors on le rentre dans le tableau
            if (!array_key_exists($ligne['animal_id'], $tab)) {

                //réorganisation des données
                $tab[$ligne['animal_id']] = [
                    'id' => $ligne['animal_id'],
                    'nom' => $ligne['animal_nom'],
                    'description' => $ligne['animal_description'],
                    'image' => URL.'public/images/'.$ligne['animal_image'],
                    'familles' => [
                        'idFamille' => $ligne['famille_id'],
                        'libelleFamille' => $ligne['famille_libelle'],
                        'descriptionFamille' => $ligne['famille_description']
                    ],

                ];
            }

                //ici nous rajoutons pour chaque $ligne['animal_id'] une nouvelles clé qui est continent  
                $tab[$ligne['animal_id']]['continents'][] = [

                    'idContinent' => $ligne['continent_id'],
                    'libelleContinent' => $ligne['continent_libelle']
                ];
        }



        return $tab;
    }

    /**
     * Summary of getContinents
     * @return void
     */
    public function getContinents()
    {
        $continents = $this->apiManager->getDBContinents();

        //on à access à Model et à ses fonctions 
        Model::sendJSON($continents);
      
    }

    /**
     * Summary of getFamilles
     * @return void
     */
    public function getFamilles()
    {
        $familles = $this->apiManager->getDBFamilles();

        //on à access à Model et à ses fonctions 
        Model::sendJSON($familles);
       
    }

    public function sendMessage(){
         //notre aplication pourra etre intérogée par n'importe qui grace à *
        //si nous voulons juste pour notre application nous devons mettre notre l'url
        header("Access-Control-Allow-Origin: *");

        header("Access-Control-Allow-Methods: POST, GET");

        header("Access-Control-Allow-Headers: Accept, Content-Type, Content-Length, Accept-Encoding, X-CSRFToken, Authorization");

        //on defini que le contenu sera de type json
        header("Content-Type: application/json");

        $obj = json_decode(file_get_contents('php://input'));

        // $to = 'contact@contact.contact';
        // $subject = 'Message du site MyZoo de : '.$obj->nom;
        // $message = $obj->contenu;
        // $headers = 'From : ' . $obj->email;

        // mail($to, $subject, $message, $headers);

        $messageRetour = [
            'from' => $obj->email,
            'to' => 'contact@contact.contact'
        ];
        
        //on encode les données récupérées en format JSON
        echo json_encode($messageRetour);
    }
}