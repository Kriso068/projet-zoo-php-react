<?php

require_once "./models/Model.php";

class AdminManager extends Model{


    /**
     * Summary of getPasswordUser
     * @param string $login
     * @return mixed
     * on récupère les infos de la BDD
     */
    private function getPasswordUser($login)
    {
        $req = "SELECT * FROM administrateur WHERE login = :login";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindParam(':login', $login);
        $stmt->execute();

        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt->closeCursor();

        return  $admin['password'];

    }


    /**
     * Summary of isConnexionValid
     * @param string $login
     * @param string $password
     * @return bool
     * sert a vérifier si les deux mot de passe sont identique lors de la soumission du formulaire
     */
    public function isConnexionValid($login, $password)
    {
        $passwordbD = $this->getPasswordUser($login);

        return password_verify($password, $passwordbD); 
    }


}