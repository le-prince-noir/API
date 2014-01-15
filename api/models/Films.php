<?php

class films{

    private function db(){
        return new DB\SQL(
            'mysql:host=localhost;port=3306;dbname=api-dev',
            'root',
            'root'
        );
    }

    public function findAllFilm(){
        $db = $this->db();
        $sql = 'SELECT f.`name` AS `nom_film`, f.`desc_film`, f.`auteur`,  f.`date_diffusion`,  f.`date_creation`,
            group_concat(distinct c.`name` SEPARATOR "|") AS `nom_categorie`
            FROM `film` AS f
            LEFT JOIN  `film_categorie` AS fc ON fc.`id_film` = f.`id`
            LEFT JOIN  `categorie` AS c ON c.`id` = fc.`id_categorie`
            GROUP BY f.`id`';

            $db->begin();
            $pr = $db->exec($sql);
            $db->commit();

        return $pr;
    }

    public function findFilm(){
        $db = $this->db();
        $sql = 'SELECT f.`name` AS `nom_film`, f.`desc_film`, f.`auteur`,  f.`date_diffusion`,  f.`date_creation`,
            group_concat(distinct c.`name` SEPARATOR "|") AS `nom_categorie`
            FROM `film` AS f
            LEFT JOIN  `film_categorie` AS fc ON fc.`id_film` = f.`id`
            LEFT JOIN  `categorie` AS c ON c.`id` = fc.`id_categorie`
            WHERE f.`id` ='.F3::get('PARAMS.id');

            $db->begin();
            $pr = $db->exec($sql);
            $db->commit();

        return $pr;
    }

    public function createFilm(){

        $db = $this->db();

        $name = F3::get('POST.name');
        $desc = F3::get('POST.desc_film');
        $auteur = F3::get('POST.auteur');
        $date_diffusion = F3::get('POST.date_diffusion');
        $date_creation = time();

        $valid = ($name != "" && $desc != "" && $auteur != "" && $date_diffusion != "") ? true : false;

        $sql = "INSERT INTO `film` (`name`, `desc_film`, `auteur`, `date_diffusion`, `date_creation`)
        VALUES('$name', '$desc', '$auteur', '$date_diffusion', '$date_creation' )";

        $db->begin();
        $db->exec($sql);
        $db->commit();

        if($valid)
            return true;
        else
            return false;
    }

    public function updateFilm(){

        $db = $this->db();
        $data = Put::get();

        $name = (isset($data['name']) && $data['name'] != "") ? '`name`="'.$data['name'].'",' : "";
        $desc = (isset($data['desc_film']) && $data['desc_film'] != "") ? '`desc_film`="'.$data['desc_film'].'",' : "";
        $auteur = (isset($data['auteur']) && $data['auteur'] != "") ? '`auteur`="'.$data['auteur'].'",' : "";
        $date_diffusion = (isset($data['date_diffusion']) && $data['date_diffusion'] != "") ? '`date_diffusion`="'.$data['date_diffusion'].'",' : "";

        $suite_requete = $name.$desc.$auteur.$date_diffusion;
        $suite_requete = substr($suite_requete, 0, -1);
        if( $suite_requete != "" && isset($data['id']) && is_numeric($data['id'])){
            $sql = "UPDATE `film` SET ".$suite_requete." WHERE `id` = ".$data['id'];

            $db->begin();
            $db->exec($sql);
            $db->commit();
            Api::response(200, $data);
        }else{
          Api::response(400, array('error'=>'Erreur pdt la modification'));
        }
    }

    public function deleteFilm(){

        $db = $this->db();

        $sql = 'DELETE FROM `film` WHERE `id` ='.F3::get('GET.id');

        $db->begin();
        $db->exec($sql);
        $db->commit();

        return true;
    }

    public function FindCat(){
        $db = $this->db();

        $sql = 'SELECT f.`name` AS `nom_film`, f.`desc_film`, f.`auteur`,  f.`date_diffusion`,  f.`date_creation`,
        group_concat(distinct c.`name` SEPARATOR "|") AS `nom_categorie`
        FROM `film` AS f
        LEFT JOIN  `film_categorie` AS fc ON fc.`id_film` = f.`id`
        LEFT JOIN  `categorie` AS c ON c.`id` = fc.`id_categorie`
        WHERE c.`slug_cat` = "'.F3::get('PARAMS.cat').'"
        GROUP BY f.`id`';

        $db->begin();
        $pr = $db->exec($sql);
        $db->commit();

        return $pr;
    }

    public function userAction($choix){
        $db = $this->db();

        $sql = 'SELECT f.`name` AS `nom_film`, f.`desc_film`, f.`auteur`,  f.`date_diffusion`,  f.`date_creation`,
        group_concat(distinct c.`name` SEPARATOR "|") AS `nom_categorie`
        FROM `film` AS f
        LEFT JOIN  `film_categorie` AS fc ON fc.`id_film` = f.`id`
        LEFT JOIN  `categorie` AS c ON c.`id` = fc.`id_categorie`
        LEFT JOIN  `user` AS u ON u.`pseudo` = "'.F3::get('PARAMS.pseudo').'"
        LEFT JOIN  `'.$choix.'` AS choix ON choix.`id_user` = `u`.id
        WHERE f.`id` = choix.`id_film`
        GROUP BY f.`id`';

        $db->begin();
        $pr = $db->exec($sql);
        $db->commit();

        return $pr;
    }
}