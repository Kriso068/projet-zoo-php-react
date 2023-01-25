<?php

require "./controllers/back/Securite.class.php";
require "./models/back/admin.management.php";

class AdminController
{
    private $adminManager;

    public function __construct()
    {
        $this->adminManager = new AdminManager();
    }

    public function getPageLogin()
    {

        require_once "views/login.php";
    }


    /**
     * Summary of getConnexion
     * @return void
     */
    public function getConnexion()
    {
        // echo password_hash('admin', PASSWORD_DEFAULT);

        if(!empty($_POST['login']) && !empty($_POST['password'])) {

            $login = Securite::secureHtml($_POST['login']);
            $password = Securite::secureHtml($_POST['password']);

            if ($this->adminManager->isConnexionValid($login, $password)) {

                $_SESSION['access'] = 'admin';

                header("Location: ".URL."/back/admin");


            }else {
                header("Location: ".URL."/back/login");
            }

        }
        
    }

    /**
     * 
     * @return void
     */
    public function getAccueilAdmin()
    {
        if(Securite::verifAccessSession()) {

            require_once "views/accueilAdmin.php";
        }else {
            header("Location: ".URL."/back/login");
        }
    }

    public function getDeconnexion()
    {
        session_destroy();
        header("Location: ".URL."/back/login");
    }
}