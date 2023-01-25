<?php

require_once 'models/Model.php';

class AnimauxManager extends Model
{

    public function getAnimaux()
    {
        $req = 'SELECT * FROM animal ';
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();

        $animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt->closeCursor();

        return $animaux;

    }

    public function deleteDbanimalContinent($idAnimal)
    {
        $req = 'DELETE FROM animal_continent WHERE animal_id = :idAnimal';
        $stmt = $this->getBdd()->prepare($req);
        $stmt -> bindParam(':idAnimal',$idAnimal, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }
    

    public function deleteDbAnimal($idAnimal)
    {
        $req = 'DELETE FROM animal WHERE animal_id = :idAnimal';
        $stmt = $this->getBdd()->prepare($req);
        $stmt -> bindParam(':idAnimal',$idAnimal, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

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


    public function createanimal($nom, $description, $image, $idFamille){
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