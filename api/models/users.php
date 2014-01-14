<?php

class users{

    private function db(){
        return new DB\SQL(
            'mysql:host=localhost;port=3306;dbname=api-dev',
            'root',
            'root'
        );
    }

    public function findAllUser(){
        $db = $this->db();
        $sql = 'SELECT u.`pseudo`, u.`email`
        FROM `user` AS u';

        $db->begin();
        $pr = $db->exec($sql);
        $db->commit();

        return $pr;
    }

    public function deleteUser(){

        $db = $this->db();

        $sql = 'DELETE FROM `user` WHERE `id` ='.F3::get('GET.id');

        $db->begin();
        $db->exec($sql);
        $db->commit();

        return true;
    }

    public function createUser(){

        $db = $this->db();

        $pseudo = F3::get('POST.pseudo');
        $mdp = md5(F3::get('POST.mdp'));
        $email = F3::get('POST.email');
        $date_creation = time();
        $token = sha1($pseudo.F3::get('POST.mdp'));

        $valid = ($pseudo != "" && $mdp != "" && $email != "") ? true : false;

        $sql = "INSERT INTO `user` (`pseudo`, `mdp`, `email`, `token`, `date_creation`)
        VALUES('$pseudo', '$mdp', '$email', '$token', '$date_creation' )";

        $db->begin();
        $db->exec($sql);
        $db->commit();

        if($valid)
            return true;
        else
            return false;
    }

    public function updateUser(){

        $db = $this->db();

        $pseudo = F3::get('PUT.pseudo');
        $mdp = F3::get('PUT.mdp');
        $email = F3::get('PUT.email');

        $pseudo = ($pseudo != "") ? '`pseudo`="'.$pseudo.'",' : "";
        $mdp = ($mdp != "") ? '`mdp`="'.$desc.'",' : "";
        $email = ($email != "") ? '`email`="'.$email.'",' : "";

        $suite_requete = $pseudo.$mdp.$email;
        $suite_requete = substr($suite_requete, 0, -1);

        $sql = "UPDATE `user` SET ".$suite_requete." WHERE `id` = ".F3::get('PUT.id');

        $db->begin();
        $db->exec($sql);
        $db->commit();

        return true;
    }
}