<?php

class usersController{
	private $model = null;

	public function __construct(){

		$this->model = new users();
	}

	// récupère tout les utilisateurs
	public function actionFindAllUser(){
		$users = $this->model->findAllUser();

        if($users)
            Api::response(200, array('valid'=>$users));
        else
            Api::response(400, array('error'=>'Un problème est survenu'));
	}

	// récupère un utilisateur
	public function actionFindUser(){
		$user = $this->model->findUser();

        if($user)
            Api::response(200, array('valid'=>$user));
        else
            Api::response(400, array('error'=>'Un problème est survenu'));
	}

	// supprime un utilisateur
    public function actionDeleteUser(){
		$del = $this->model->deleteUser();

		if($del)
	 		Api::response(200, array('valid'=>'Utilisateur bien supprime'));
        else
            Api::response(400, array('error'=>'Un problème est survenu'));

    }

    // création d'un utilisateur
	public function actionCreateUser(){
		$create = $this->model->createUser();

        if($create)
            Api::response(200, array('valid'=>'Utilisateur ajoute'));
        else
            Api::response(400, array('error'=>'Un problème est survenu'));
	}

	// modification d'un utilisateur
	public function actionUpdateUser(){
		$modif = $this->model->updateUser();

		if($modif){
			Api::response(200, array('valid'=>'Utilisateur modifie'));
		}else{
			Api::response(400, array('error'=>'Erreur pdt la modification'));
		}
	}

}