<?php

require_once "./models/Model.php";

class AdminManager extends Model{


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


    public function isConnexionValid($login, $password)
    {
        $passwordbD = $this->getPasswordUser($login);

        return password_verify($password, $passwordbD); 
    }


}