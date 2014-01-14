<?php

class usersController{
	private $db;

	public function __construct(){
		$this->db = new DB\SQL(
		    'mysql:host=localhost;port=3306;dbname=api-dev',
		    'root',
		    'root'
		);
	}

	// récupère tout les films
	public function actionFindAllUser(){
		$sql = 'SELECT u.`pseudo`, u.`email`
		FROM `user` AS u';

		$this->db->begin();
		$pr = $this->db->exec($sql);
		$this->db->commit();

		Api::response(200, $pr);
	}


}