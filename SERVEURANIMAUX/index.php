 <?php

 session_start();

 
require_once 'controllers/front/API.controller.php';
require_once 'controllers/back/admin.controller.php';
require_once 'controllers/back/familles.controller.php';
require_once 'controllers/back/animaux.controller.php';

$apiController = new APIController();
$adminController = new AdminController();
$familleController = new FamillesController();
$animauxController = new AnimauxController();

//defini une constante URL qui remplace index par vide
define("URL", str_replace("index.php","",(isset($_SERVER['HTTPS']) ? "https" : "http")."://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

//donc url sera : https://SERVERURANIMAUX/$url[0]
// OU
//donc url sera : https://SERVERURANIMAUX/$url[0]/$url[1]
// OU
//donc url sera : https://SERVERURANIMAUX/$url[0]/$url[1]/$url[2]


try{
    if(empty($_GET['page'])){
        throw new Exception("La page n'existe pas");
    } else {
        $url = explode("/",filter_var($_GET['page'],FILTER_SANITIZE_URL));
        if(empty($url[0]) || empty($url[1])) throw new Exception ("La page n'existe pas");

        //$url[0] est front
        switch($url[0]){
            case "front" : 
                //$url[1] est animaux || animal || continents .....
                switch($url[1]){
                    case "animaux": 
                        if(!isset($url[2]) || !isset($url[3])) {
                             $apiController->getAnimaux(-1,-1);
                        }else {
                            $apiController->getAnimaux((int)$url[2], (int)$url[3]);
                        }
                    break;
                    case "animal": 
                        if (empty($url[2]))throw new Exception ("L'identifiant de l'animal est manquant");
                        $apiController->getAnimal($url[2]);
                    break;
                    case "continents": 
                        $apiController->getContinents();
                    break;
                    case "familles": 
                        $apiController->getFamilles();
                    break;
                    case "sendMessages": 
                        $apiController->sendMessage();
                    break;
                    default : throw new Exception ("La page n'existe pas");
                }
            break;

            //$url[0] est back
            case "back":
                //$url[1] est login || connexion || admin .....
                switch ($url[1]) {
                    case 'login': 
                        $adminController->getPageLogin();
                    break;
                    case 'connexion': 
                        $adminController->getConnexion();
                    break;
                    case 'admin': 
                        $adminController->getAccueilAdmin();
                    break;
                    case 'deconnexion': 
                        $adminController->getDeconnexion();
                    break;

                    case "familles":
                        //$url[2] est visualisation|| validationSuppression || validationModification .....
                        switch ($url[2]) {
                            case 'visualisation':
                                $familleController->visualisation();
                            break;
                            case 'validationSuppression':
                                $familleController->suppression();
                            break;
                            case 'validationModification':
                                $familleController->modification();
                            break;
                            case "creation" : 
                                $familleController->creationTemplate();
                            break;
                            case "creationValidation" : 
                                $familleController->creationValidation();
                            break;

                            default : throw new Exception ("La page n'existe pas");
                        }
                        break;
                    
                    

                    case "animaux":
                        //$url[2] est visualisation|| validationSuppression || validationModification .....
                        switch ($url[2]) {
                            case 'visualisation':
                                $animauxController->visualisation();
                            break;
                            case 'validationSuppression':
                                $animauxController->suppression();
                            break;
                            case 'modification':
                                $animauxController->modification($url[3]);
                            break;
                            case 'modificationValidation':
                                $animauxController->modificationValidation();
                            break;
                            case "creation" : 
                                $animauxController->creationTemplate();
                            break;
                            case "creationValidation" : 
                                $animauxController->creationValidation();
                            break;

                            default : throw new Exception ("La page n'existe pas");
                        }
                         break;
                    
                    default : throw new Exception ("La page n'existe pas");
                }
            break;
                    
            default: throw new Exception("La page n'existe pas");
        }
    }
} catch (Exception $e){
    $msg = $e->getMessage();
    echo $msg;
    echo "<a href='" . URL . "/back/login'>Login</a>";

} 
