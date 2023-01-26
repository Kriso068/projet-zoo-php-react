<?php

require_once 'models/Model.php';

class ContinentsManager extends Model
{

    /**
     * Summary of getContinents
     * @return array
     * récupère un tableau des continents
     */
    public function getContinents()
    {
        $req = 'SELECT * FROM continent ';
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();

        $continents = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt->closeCursor();

        return $continents;

    }


    /**
     * Summary of addContinentAnimal
     * @param int $idAnimal
     * @param int $idContinent
     * @return void
     * ajoute un animal grace a sont ID dans la table animal_continent
     */
    public function addContinentAnimal($idAnimal, $idContinent)
    {
        $req ="INSERT INTO animal_continent (animal_id, continent_id)
                values (:idAnimal,:idContinent)
            ";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":idAnimal",$idAnimal,PDO::PARAM_INT);
            $stmt->bindValue(":idContinent",$idContinent,PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
          
    }

    /**
     * Summary of deleteDBContinentAnimal
     * @param mixed $idAnimal
     * @param mixed $idContinent
     * @return void
     * supprimer un animal grace a sont ID dans la table animal_continent
     */
    public function deleteDBContinentAnimal($idAnimal,$idContinent){
        $req = "DELETE FROM animal_continent 
                WHERE animal_id = :idAnimal 
                AND continent_id = :idContinent";

                    
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":idAnimal",$idAnimal,PDO::PARAM_INT);
            $stmt->bindValue(":idContinent",$idContinent,PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
    }

    /**
     * Summary of verificationExisteAnimalContinent
     * @param int $idAnimal
     * @param int $idContinent
     * @return bool
     * verification si un animal est dans la table animal_continent
     */
    public function verificationExisteAnimalContinent($idAnimal,$idContinent){
        $req = "SELECT count(*) AS 'nb'
                FROM animal_continent ac
                WHERE ac.animal_id = :idAnimal 
                AND ac.continent_id = :idContinent";

            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":idAnimal",$idAnimal,PDO::PARAM_INT);
            $stmt->bindValue(":idContinent",$idContinent,PDO::PARAM_INT);
            $stmt->execute();
            $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();


            if($resultat['nb'] >=1) return true;
            return false;
    }

    
}