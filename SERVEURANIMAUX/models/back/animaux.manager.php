<?php

require_once 'models/Model.php';

class AnimauxManager extends Model
{

    /**
     * Summary of getAnimaux
     * @return array
     * récupère un tableau des animaux
     */
    public function getAnimaux()
    {
        $req = 'SELECT * FROM animal ';
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();

        $animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt->closeCursor();

        return $animaux;

    }

    /**
     * Summary of deleteDbanimalContinent
     * @param int $idAnimal
     * @return void
     * supprmier dans la base de donnée un animal selon sont ID dans la table animla_continent
     */
    public function deleteDbanimalContinent($idAnimal)
    {
        $req = 'DELETE FROM animal_continent WHERE animal_id = :idAnimal';
        $stmt = $this->getBdd()->prepare($req);
        $stmt -> bindParam(':idAnimal',$idAnimal, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }
    

    /**
     * Summary of deleteDbAnimal
     * @param int $idAnimal
     * @return void
     * supprmier dans la base de donnée un animal selon sont ID
     */
    public function deleteDbAnimal($idAnimal)
    {
        $req = 'DELETE FROM animal WHERE animal_id = :idAnimal';
        $stmt = $this->getBdd()->prepare($req);
        $stmt -> bindParam(':idAnimal',$idAnimal, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }


    /**
     * Summary of compterAnimaux
     * @param int $idAnimal
     * @return mixed
     * donne un une reposne si il y a un animal avec sont ID
     */
    public function compterAnimaux($idAnimal)
    {
        $req = "SELECT count(*) as 'nb' 
                FROM animal a 
                INNER JOIN famille f
                ON a.animal_id = f.animal_id
                WHERE a.animal_id = :idAnimal";

        $stmt = $this->getBdd()->prepare($req);
        $stmt -> bindParam(':idAnimal',$idAnimal, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result['nb'];
    }


    /**
     * Summary of updateAnimal
     * @param int $idAnimal
     * @param string $nom
     * @param string $description
     * @param string $image
     * @param int $idFamille
     * @return void
     * update de l'animal grace à sont ID
     */
    public function updateAnimal($idAnimal,$nom,$description,$image,$idFamille){
        $req ="Update animal 
        set animal_nom = :nom, animal_description = :description, animal_image = :image, famille_id = :idFamille
        where animal_id= :idAnimal";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idAnimal",$idAnimal,PDO::PARAM_INT);
        $stmt->bindValue(":idFamille",$idFamille,PDO::PARAM_INT);
        $stmt->bindValue(":nom",$nom,PDO::PARAM_STR);
        $stmt->bindValue(":description",$description,PDO::PARAM_STR);
        $stmt->bindValue(":image",$image,PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
    }

    /**
     * Summary of creatAanimal
     * @param string $nom
     * @param string $description
     * @param string $image
     * @param int $idFamille
     * @return bool|string
     * création d'un animal
     */
    public function createAnimal($nom, $description, $image, $idFamille){
        $req ="Insert into animal (animal_nom, animal_description, animal_image, famille_id)
            values (:nom, :description, :image, :idFamille)
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":nom",$nom,PDO::PARAM_STR);
        $stmt->bindValue(":description",$description,PDO::PARAM_STR);
        $stmt->bindValue(":image",$image,PDO::PARAM_STR);
        $stmt->bindValue(":idFamille",$idFamille,PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
        
        return $this->getBdd()->lastInsertId();
    }

    /**
     * Summary of getAnimal
     * @param int $idAnimal
     * @return array
     * return un animal grace à sont ID
     */
    public function getAnimal($idAnimal)
    {
        $req = 'SELECT a.animal_id, a.animal_nom, a.animal_description, a.animal_image, a.famille_id, continent_id
                FROM animal a
                INNER JOIN famille f
                ON a.famille_id = f.famille_id
                LEFT JOIN animal_continent ac
                ON ac.animal_id = a.animal_id
                WHERE a.animal_id = :idAnimal';

            $stmt = $this->getBdd()->prepare($req);
         
            $stmt->bindValue(":idAnimal",$idAnimal,PDO::PARAM_INT);
            $stmt->execute();
            $lignesAnimal = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();

        return $lignesAnimal;

    }

    /**
     * Summary of getImageAnimal
     * @param int $idAnimal
     * @return mixed
     *  récupère l'image d'un animal grace à sont ID
     */
    public function getImageAnimal($idAnimal)
    {
        $req = 'SELECT animal_image 
                FROM animal
                WHERE animal_id = :idAnimal';


        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idAnimal",$idAnimal,PDO::PARAM_INT);
        $stmt->execute();

        $image = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt->closeCursor();

        return $image['animal_image'];

    }
   

    
}