<?php

require_once 'models/Model.php';

class APIManager extends Model
{
    /**
     * Summary of getDBAnimaux
     * @return array
     */
    public function getDBAnimaux($idFamille, $idContinent)
    {

        $whereClause = '';

        if($idFamille !== -1 || $idContinent !== -1){
            $whereClause .= 'WHERE ';
        }
        if($idFamille !== -1){
            $whereClause .= 'f.famille_id = :idFamille';
        }
        if($idFamille !== -1 && $idContinent !== -1){
            $whereClause .= ' AND ';
        }
        if( $idContinent !== -1){
            // $whereClause .= 'c.continent_id = :idContinent';
            $whereClause .=  "a.animal_id IN (
                select animal_id from animal_continent where continent_id = :idContinent
            )";
        }


        $req = 'SELECT a.animal_id, a.animal_nom, a.animal_description, a.animal_image, f.famille_id, f.famille_libelle, f.famille_description, c.continent_id, c.continent_libelle
                FROM animal a
                INNER JOIN famille f
                ON f.famille_id = a.famille_id
                LEFT JOIN animal_continent ac 
                ON ac.animal_id = a.animal_id
                LEFT JOIN continent c
                ON ac.continent_id = c.continent_id '.$whereClause;

        $stmt = $this->getBdd()->prepare($req);

        if($idFamille !== -1){
            $stmt->bindParam(':idFamille',$idFamille);
        }

        if($idContinent !== -1){
            $stmt->bindParam(':idContinent',$idContinent);
        }

        $stmt->execute();

        $animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt->closeCursor();

        return $animaux;
    }

    /**
     * Summary of getDBAnimal
     * @param mixed $idAnimal
     * @return array
     */
    public function getDBAnimal($idAnimal)
    {

        $req = 'SELECT * 
                FROM animal a
                INNER JOIN famille f
                ON f.famille_id = a.famille_id
                INNER JOIN animal_continent ac 
                ON ac.animal_id = a.animal_id
                INNER JOIN continent c
                ON ac.continent_id = c.continent_id
                WHERE a.animal_id = :idAnimal';

        $stmt = $this->getBdd()->prepare($req);

        //PDO::PARAM_INT sera la pour juste authoriser les integer
        $stmt->bindParam(':idAnimal', $idAnimal, PDO::PARAM_INT);

        $stmt->execute();

        $lignesAnimal = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt->closeCursor();

        return $lignesAnimal;
    }


    public function getDBContinents()
    {
        $req = 'SELECT * 
                FROM continent c'
               ;

        $stmt = $this->getBdd()->prepare($req);

        $stmt->execute();

        $continents = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt->closeCursor();

        return $continents;
    }


    public function getDBFamilles()
    {
        $req = 'SELECT * 
                FROM famille f'
            ;

        $stmt = $this->getBdd()->prepare($req);

        $stmt->execute();

        $familles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt->closeCursor();

        return $familles;
    }
}