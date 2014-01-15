<?php

class filmsController{

	private $model = null;

	public function __construct(){

		$this->model = new films();
	}

	// récupère tout les films
	public function actionFindAllFilm(){
		$allFilms = $this->model->findAllFilm();
		Api::response(200, $allFilms);
	}
	public function actionFindFilm(){
		$film = $this->model->findFilm();
		Api::response(200, $film);
	}

	public function actionCreateFilm(){
		$creationFilm = $this->model->createFilm();

		if($creationFilm)
			Api::response(200, array('valid'=>'Film ajoute'));
		else
			Api::response(400, array('error'=>'Un problème est survenu'));
	}

	// récupère les films par rapport à la catégorie
	public function actionFindCat(){
		$findCat = $this->model->FindCat();
		Api::response(200, $findCat);
	}

	// récupère les like de l'utilisateur
	public function actionLikeUser(){
		$likeUser = $this->model->userAction('film_like');
		Api::response(200, $likeUser);
	}

	// récupère les films vu de l'utilisateur
	public function actionViewUser(){
		$viewUser = $this->model->userAction('film_view');
		Api::response(200, $viewUser);
	}

	// récupère les films que l'utilisateur aimerait voir
	public function actionLoveUser(){
		$viewUser = $this->model->userAction('film_love');
		Api::response(200, $loveUser);
	}

	public function actionDeleteFilm(){
		$this->model->deleteFilm();
		Api::response(200, array('valid'=>'Film bien supprime'));
	}

	public function actionUpdateFilm(){
		$this->model->updateFilm();
	}
}