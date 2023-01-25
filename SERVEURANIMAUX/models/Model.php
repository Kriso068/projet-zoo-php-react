<?php


abstract class Model
{
    private static $pdo;


    private static function setBdd()
    {
        self::$pdo = new PDO('mysql:host=localhost;dbname=zoo;charset=utf8', 'root', '');
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }


    protected function getBdd()
    {

        //pour verifier si nous somme déjà connecté sinon on ce connect
        if(self::$pdo === null) {

            self::setBdd();
        }

        return self::$pdo;
    }

      /**
       * Summary of sendJSON
       * @param mixed $infos
       * @return void
       */

    public static function sendJSON($infos)
    {
        //notre aplication pourra etre intérogée par n'importe qui grace à *
        //si nous voulons juste pour notre application nous devons mettre notre l'url
        header("Access-Control-Allow-Origin: *");

        //on defini que le contenu sera de type json
        header("Content-Type: application/json");
        
        //on encode les données récupérées en format JSON
        echo json_encode($infos);
    }
}