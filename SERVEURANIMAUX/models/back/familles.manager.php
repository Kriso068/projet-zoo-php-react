<?php

require_once 'models/Model.php';

class FamillesManager extends Model
{

    /**
     * Summary of getFamilles
     * @return array
     * récupère un tableau des familles
     */
    public function getFamilles()
    {
        $req = 'SELECT * FROM famille ';
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();

        $familles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt->closeCursor();

        return $familles;

    }


    /**
     * Summary of deleteDbFamille
     * @param int $idFamille
     * @return void
     * supprmier dans la base de donnée une famille selon sont ID
     */
    public function deleteDbFamilles($idFamille)
    {
        $req = 'DELETE FROM famille WHERE famille_id = :idFamille';
        $stmt = $this->getBdd()->prepare($req);
        $stmt -> bindParam(':idFamille',$idFamille, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }


    /**
     * Summary of compterAnimaux
     * @param int $idFamille
     * @return mixed
     * donne un une reposne si il y a une famille avec sont ID
     */
    public function compterAnimaux($idFamille)
    {
        $req = "SELECT count(*) as 'nb' 
                FROM famille f 
                INNER JOIN animal a
                ON a.famille_id = f.famille_id
                WHERE f.famille_id = :idFamille";

        $stmt = $this->getBdd()->prepare($req);
        $stmt -> bindParam(':idFamille',$idFamille, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result['nb'];
    }

    /**
     * Summary of updateFamille
     * @param int $idFamille
     * @param string $libelle
     * @param string $description
     * @return void
     * update de la famille grace à sont ID
     */
    public function updateFamille($idFamille, $libelle, $description)
    {
        $req = "Update famille
                set famille_libelle = :libelle, famille_description = :description
                WHERE famille_id = :idFamille";

        $stmt = $this->getBdd()->prepare($req);
        $stmt -> bindParam(':idFamille',$idFamille, PDO::PARAM_INT);
        $stmt -> bindParam(':libelle',$libelle, PDO::PARAM_STR);
        $stmt -> bindParam(':description',$description, PDO::PARAM_STR);
        $stmt->execute();

       
        $stmt->closeCursor();

    }

    /**
     * Summary of createFamille
     * @param int $libelle
     * @param int $description
     * @return bool|string
     * creation d'une famille
     */
    public function createFamille($libelle,$description){
        $req ="Insert into famille (famille_libelle,famille_description)
            values (:libelle,:description)
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":libelle",$libelle,PDO::PARAM_STR);
        $stmt->bindValue(":description",$description,PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();

        return $this->getBdd()->lastInsertId();

    }


    
}