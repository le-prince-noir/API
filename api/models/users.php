<?php

class users{
    private $url = "localhost";
    private $login = "root";
    private $mdp = "root";
    private $base = "api-dev";

    private function db(){

        return new DB\SQL(
            'mysql:host='.$this->url.';port=3306;dbname='.$this->base,
            $this->login,
            $this->mdp
        );
    }

    // récupère le niveau de l'utilisateur
    private function getNiveauUser($token){

        $db = $this->db();
        $sql = 'SELECT u.`niveau`
        FROM `user` AS u
        WHERE u.`token` = "'.$token.'"';

        $db->begin();
        $niveau = $db->exec($sql);
        $db->commit();
        $niveau = $niveau[0]['niveau'];
        return $niveau;
    }

    // récupère tout les utilisateurs
    public function findAllUser(){
        $db = $this->db();

        // récupère le niveau de l'user
        $niveau = $this->getNiveauUser(F3::get('GET.token'));

        if ($niveau == 'super-admin' || $niveau == 'admin'){
            $sql = 'SELECT u.`pseudo`, u.`email`, u.`niveau`, u.`token`
            FROM `user` AS u';
        }else{
            $sql = 'SELECT u.`pseudo`, u.`email`, u.`niveau`
            FROM `user` AS u';
        }
        $db->begin();
        $users = $db->exec($sql);
        $db->commit();

        return $users;
    }

    // récupère un utilisateur
    public function findUser(){
        $db = $this->db();

        // récupère le niveau de l'user
        $niveau = $this->getNiveauUser(F3::get('GET.token'));
        if ($niveau == 'super-admin' || $niveau == 'admin'){
            $sql = 'SELECT u.`pseudo`, u.`email`, u.`niveau`, u.`token`
            FROM `user` AS u
            WHERE u.`id` = '.F3::get('PARAMS.id');
        }
        if ($niveau == 'user'){
            $sql = 'SELECT u.`pseudo`, u.`email`, u.`niveau`, u.`token`
            FROM `user` AS u
            WHERE u.`id` = '.F3::get('PARAMS.id').' AND u.`token` ="'.F3::get('GET.token').'"';
        }
        $db->begin();
        $user = $db->exec($sql);
        $db->commit();

        return $user;
    }

    // supprime un utilisateur
    // mais aussi les films like, vu, et qu'il aimerait voir
    public function deleteUser(){

        $db = $this->db();

        // récupère le niveau de l'user
        $niveau = $this->getNiveauUser(F3::get('PARAMS.token'));

        if ($niveau == 'super-admin'){
            $sql = "DELETE FROM `user` WHERE `id` =".F3::get('PARAMS.id') ;
        }
        if ($niveau == 'admin'){
            $sql = "DELETE FROM `user` WHERE `id` =".F3::get('PARAMS.id')." AND `niveau` IN('user','admin')" ;
        }
        if ($niveau == 'user'){
            $sql = "DELETE FROM `user` WHERE `id` =".F3::get('PARAMS.id')." AND `niveau` = 'user' AND `token` ='".F3::get('GET.token')."'";
        }

        $db->begin();
        $result = $db->exec($sql);
        $db->commit();
        if($result){
            $array = array('film_like','film_view','film_love');
            foreach ($array as $table) {
                $db->begin();
                $sql = "DELETE FROM `$table` WHERE `id_user` =". F3::get('PARAMS.id');
                $db->exec($sql);
                $db->commit();
            }
            return true;
        }else{
            return false;
        }
    }

    // création d'un utilisateur
    public function createUser(){

        $db = $this->db();

        $pseudo = F3::get('POST.pseudo');
        $mdp = md5(F3::get('POST.mdp'));
        $email = F3::get('POST.email');
        $niveau = F3::get('POST.niveau');
        $date_creation = time();
        $token = sha1($pseudo.F3::get('POST.mdp'));

        $valid = ($pseudo != "" && $mdp != "" && $email != "") ? true : false;

        $sql = "INSERT INTO `user` (`niveau`,`pseudo`, `mdp`, `email`, `token`, `date_creation`)
        VALUES('$niveau','$pseudo', '$mdp', '$email', '$token', '$date_creation' )";

        $db->begin();
        $create = $db->exec($sql);
        $db->commit();

        return $create;
    }

    // modification un utilisateur
    public function updateUser(){

        $db = $this->db();
        $data = Put::get();

        $pseudo = (isset($data['pseudo']) && $data['pseudo'] != "") ? '`pseudo`="'.$data['pseudo'].'",' : "";
        $mdp = (isset($data['mdp']) && $data['mdp'] != "") ? '`mdp`="'.$data['mdp'].'",' : "";
        $email = (isset($data['email']) && $data['email'] != "") ? '`email`="'.$data['email'].'",' : "";

        $suite_requete = $pseudo.$mdp.$email;
        $suite_requete = substr($suite_requete, 0, -1);

        if( $suite_requete != "" && isset($data['id']) && is_numeric($data['id'])){
            $sql = "UPDATE `user` SET ".$suite_requete." WHERE `id` = ".$data['id'];

            $db->begin();
            $db->exec($sql);
            $db->commit();
            return true;
        }else{
          return false;
        }
    }
}