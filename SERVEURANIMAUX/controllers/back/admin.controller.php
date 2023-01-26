<?php

require "./controllers/back/Securite.class.php";
require "./models/back/admin.management.php";

class AdminController
{
    /**
     * Summary of adminManager
     * @var AdminManager
     */
    private $adminManager;


    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->adminManager = new AdminManager();
    }


    /**
     * Summary of getPageLogin
     * @return void
     * nous sert à aller à la page login
     */
    public function getPageLogin()
    {
        require_once "views/login.php";
    }


    /**
     * Summary of getConnexion
     * @return void
     * login
     */
    public function getConnexion()
    {
        //verification si les champs sont vide
        if(!empty($_POST['login']) && !empty($_POST['password'])) {

            //on sécurise la donnée récupéré garce à la fonction secrureHtml qui est dans './controllers/back/Securite.class.php';
            $login = Securite::secureHtml($_POST['login']);
            $password = Securite::secureHtml($_POST['password']);

            //on controlle si les deux mot de passe sont identique si oui alors
            if ($this->adminManager->isConnexionValid($login, $password)) {

                $_SESSION['access'] = 'admin';

                //on redirige vers la page admin
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