<?php

class usersController{
	private $model = null;

	public function __construct(){

		$this->model = new users();
	}

	// récupère tout les users
	public function actionFindAllUser(){
		$allUsers = $this->model->findAllUser();
		Api::response(200, $allUsers);
	}

    public function actionDeleteUser(){
		$this->model->deleteUser();
		Api::response(200, array('valid'=>'Utilisateur bien supprime'));
    }

	public function actionCreateUser(){
		$creationUser = $this->model->createUser();

		if($creationUser)
			Api::response(200, array('valid'=>'Utilisateur ajoute'));
		else
			Api::response(400, array('error'=>'Un problème est survenu'));
	}

	public function actionUpdateUser(){
		$this->model->updateUser();
		Api::response(200, array('valid'=>'Utilisateur bien modifie'));
	}

}