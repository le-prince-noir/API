<?php

class users{

    private function db(){
        return new DB\SQL(
            'mysql:host=localhost;port=3306;dbname=api-dev',
            'root',
            'root'
        );
    }

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
        $pr = $db->exec($sql);
        $db->commit();

        if($pr)
            Api::response(200, array('valid'=>$pr));
        else
            Api::response(400, array('error'=>'Un problème est survenu'));
    }

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
        $pr = $db->exec($sql);
        $db->commit();

        if($pr)
            Api::response(200, array('valid'=>$pr));
        else
            Api::response(400, array('error'=>'Un problème est survenu'));
    }

    public function deleteUser(){

        $db = $this->db();

        // récupère le niveau de l'user
        $niveau = $this->getNiveauUser(F3::get('GET.token'));

        if ($niveau == 'super-admin'){
            $sql = "DELETE FROM `user` WHERE `id` =".F3::get('GET.id') ;
        }
        if ($niveau == 'admin'){
            $sql = "DELETE FROM `user` WHERE `id` =".F3::get('GET.id')." AND `niveau` IN('user','admin')" ;
        }
        if ($niveau == 'user'){
            $sql = "DELETE FROM `user` WHERE `id` =".F3::get('GET.id')." AND `niveau` = 'user' AND `token` ='".F3::get('GET.token')."'";
        }

        $db->begin();
        $result = $db->exec($sql);
        $db->commit();
        if($result){
            $array = array('film_like','film_view','film_love');
            foreach ($array as $table) {
                $db->begin();
                $sql = "DELETE FROM `$table` WHERE `id_user` =". F3::get('GET.id');
                $db->exec($sql);
                $db->commit();
            }


            Api::response(200, array('valid'=>'Utilisateur bien supprime'));
        }else{
            Api::response(400, array('error'=>'Un problème est survenu'));
        }
    }

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
        $db->exec($sql);
        $db->commit();

        if($valid)
            Api::response(200, array('valid'=>'Utilisateur ajoute'));
        else
            Api::response(400, array('error'=>'Un problème est survenu'));
    }

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
            Api::response(200, $data);
        }else{
          Api::response(400, array('error'=>'Erreur pdt la modification'));
        }
    }
}