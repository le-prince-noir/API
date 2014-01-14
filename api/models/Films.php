<?php

class films{

    private static function db(){
        return new DB\SQL(
            'mysql:host=localhost;port=3306;dbname=api-dev',
            'root',
            'root'
        );
    }

    static function __getAllFilms(){
        $db = self::db();
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
}