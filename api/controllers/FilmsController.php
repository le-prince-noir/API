<?php

class filmsController{
	private $model = null;

	public function __construct(){

		$this->model = new films();
	}

	// récupère tout les films
	public function actionFindAllFilm(){
		$films = $this->model->findAllFilm();

        if($films)
            Api::response(200, $films);
        else
            Api::response(400, array('error'=>'Un problème est survenu'));

	}

	// récupère un film
	public function actionFindFilm(){
			$id = Api::validId();

			if($id>=0){
				$film = $this->model->findFilm($id);

			if($film[0]['nom_film'] != null)
				Api::response(200, $film);
			else
				Api::response(400, array('error'=>'Aucun film ne correspond'));
		}else{
			Api::response(400, array('error'=>'Le parametre n\'est pas valide'));
		}
	}

	// création d'un film
	public function actionCreateFilm(){
		$creationFilm = $this->model->createFilm();

		if($creationFilm)
			Api::response(200, array('valid'=>'Film ajoute'));
		else
			Api::response(400, array('error'=>'Un problème est survenu'));
	}

	// récupère les films par rapport à une catégorie
	public function actionFindCat(){
		$findCat = $this->model->FindCat();

		if($findCat)
			Api::response(200, $findCat);
		else
			Api::response(400, array('error'=>'Un problème est survenu'));
	}

	// récupère les like de l'utilisateur
	public function actionLikeUser(){
		$likeUser = $this->model->userAction('film_like');

		if($likeUser)
			Api::response(200, $likeUser);
		else
			Api::response(400, array('error'=>'Un problème est survenu'));
	}

	// récupère les films vu de l'utilisateur
	public function actionViewUser(){
		$viewUser = $this->model->userAction('film_view');

		if($viewUser)
			Api::response(200, $viewUser);
		else
			Api::response(400, array('error'=>'Un problème est survenu'));
	}

	// récupère les films que l'utilisateur aimerait voir
	public function actionLoveUser(){
		$loveUser = $this->model->userAction('film_love');

		if($loveUser)
			Api::response(200, $loveUser);
		else
			Api::response(400, array('error'=>'Un problème est survenu'));
	}

	public function actionDeleteFilm(){
		$del = $this->model->deleteFilm();

		if($del)
			Api::response(200,  array('valid'=>'Film bien supprime'));
		else
			Api::response(400, array('error'=>'Un problème est survenu'));
	}

	public function actionUpdateFilm(){
		$modif = $this->model->updateFilm();

		if($modif)
			Api::response(200,  array('valid'=>'Film bien modifie'));
		else
			Api::response(400, array('error'=>'Un problème est survenu'));
	}
}