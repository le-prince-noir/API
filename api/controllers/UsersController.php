<?php

class usersController{
	private $model = null;

	public function __construct(){

		$this->model = new users();
	}

	// récupère tout les users
	public function actionFindAllUser(){
		$this->model->findAllUser();
	}
	// récupère tout les users
	public function actionFindUser(){
		$this->model->findUser();
	}

    public function actionDeleteUser(){
		$this->model->deleteUser();
    }

	public function actionCreateUser(){
		$this->model->createUser();
	}

	public function actionUpdateUser(){
		$this->model->updateUser();
	}

}