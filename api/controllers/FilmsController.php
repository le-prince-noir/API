<?php

class filmsController{
	private $db;

	public function __construct(){
		$this->db = new DB\SQL(
		    'mysql:host=localhost;port=3306;dbname=api-dev',
		    'root',
		    'root'
		);
	}

	public function actionFind(){
		$this->db->begin();
		$pr = $this->db->exec('SELECT * FROM `film`');
		$this->db->commit();

		Api::response(200, $pr );
	}

	public function actionCreate(){
		if(isset($_POST['name'])){
			$data = array('Create dog with name ' . $_POST['name']);
			Api::response(200, $data);
		}
		else{
			Api::response(400, array('error'=>'Name is missing'));
		}
	}

	public function actionFindGenre(){
		$this->db->begin();
		$pr = $this->db->exec('SELECT * FROM `film` WHERE `genre` = "'.F3::get('PARAMS.genre').'"');
		$this->db->commit();

		Api::response(200, $pr);
	}

	public function actionPref(){
		$this->db->begin();

		$pr = $this->db->exec('SELECT * FROM `film` AS f LEFT JOIN `film_user` AS u ON u.`id_user` = "'.F3::get('PARAMS.id').'" WHERE f.`id` = u.`id_film`');
		$this->db->commit();


		Api::response(200, $pr);
	}

	public function actionDelete(){
		$data = array('Delete dog with name: ' . F3::get('PARAMS.id'));
		Api::response(200, $data);
	}
}