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

	// récupère tout les films
	public function actionFindAllFilm(){
		$sql = 'SELECT f.`name` AS `nom_film`, f.`desc_film`, f.`auteur`,  f.`date_diffusion`,  f.`date_creation`,
		group_concat(distinct c.`name` SEPARATOR "|") AS `nom_categorie`
		FROM `film` AS f
		LEFT JOIN  `film_categorie` AS fc ON fc.`id_film` = f.`id`
		LEFT JOIN  `categorie` AS c ON c.`id` = fc.`id_categorie`
		GROUP BY f.`id`';

		$this->db->begin();
		$pr = $this->db->exec($sql);
		$this->db->commit();

		Api::response(200, $pr);
	}

	public function actionCreateFilm(){
		$name = F3::get('POST.name');
		$desc = F3::get('POST.desc_film');
		$auteur = F3::get('POST.auteur');
		$date_diffusion = F3::get('POST.date_diffusion');
		$date_creation = time();

		$valid = ($name != "" && $desc != "" && $auteur != "" && $date_diffusion != "") ? true : false;

		$sql = "INSERT INTO `f5ilm` (`name`, `desc_film`, `auteur`, `date_diffusion`, `date_creation`)
        VALUES('$name', '$desc', '$auteur', '$date_diffusion', '$date_creation' )";

  		$this->db->begin();
		$this->db->exec($sql);
		$this->db->commit();
		if($valid){
			Api::response(200, array('valid'=>'Film ajoute'));
		}
		else{
			Api::response(400, array('error'=>'Un problème est survenu'));
		}
	}

	// récupère les films par rapport à la catégorie
	public function actionFindCat(){
		$sql = 'SELECT f.`name` AS `nom_film`, f.`desc_film`, f.`auteur`,  f.`date_diffusion`,  f.`date_creation`,
		group_concat(distinct c.`name` SEPARATOR "|") AS `nom_categorie`
		FROM `film` AS f
		LEFT JOIN  `film_categorie` AS fc ON fc.`id_film` = f.`id`
		LEFT JOIN  `categorie` AS c ON c.`id` = fc.`id_categorie`
		WHERE c.`slug_cat` = "'.F3::get('PARAMS.cat').'"
		GROUP BY f.`id`';

		$this->db->begin();
		$pr = $this->db->exec($sql);
		$this->db->commit();

		Api::response(200, $pr);
	}

	// récupère les like de l'utilisateur
	public function actionLikeUser(){
		$sql = 'SELECT f.`name` AS `nom_film`, f.`desc_film`, f.`auteur`,  f.`date_diffusion`,  f.`date_creation`,
		group_concat(distinct c.`name` SEPARATOR "|") AS `nom_categorie`
		FROM `film` AS f
		LEFT JOIN  `film_categorie` AS fc ON fc.`id_film` = f.`id`
		LEFT JOIN  `categorie` AS c ON c.`id` = fc.`id_categorie`
		LEFT JOIN  `user` AS u ON u.`pseudo` = "'.F3::get('PARAMS.pseudo').'"
		LEFT JOIN  `film_like` AS fl ON fl.`id_user` =  `u`.id
		WHERE f.`id` = fl.`id_film`
		GROUP BY f.`id`';

		$this->db->begin();
		$pr = $this->db->exec($sql);
		$this->db->commit();

		Api::response(200, $pr);
	}

	// récupère les films vu de l'utilisateur
	public function actionViewUser(){
		$sql = 'SELECT f.`name` AS `nom_film`, f.`desc_film`, f.`auteur`,  f.`date_diffusion`,  f.`date_creation`,
		group_concat(distinct c.`name` SEPARATOR "|") AS `nom_categorie`
		FROM `film` AS f
		LEFT JOIN  `film_categorie` AS fc ON fc.`id_film` = f.`id`
		LEFT JOIN  `categorie` AS c ON c.`id` = fc.`id_categorie`
		LEFT JOIN  `user` AS u ON u.`pseudo` = "'.F3::get('PARAMS.pseudo').'"
		LEFT JOIN  `film_view` AS fv ON fv.`id_user` = `u`.id
		WHERE f.`id` = fv.`id_film`
		GROUP BY f.`id`';

		$this->db->begin();
		$pr = $this->db->exec($sql);
		$this->db->commit();

		Api::response(200, $pr);
	}

	// récupère les films que l'utilisateur aimerait voir
	public function actionLoveUser(){
		$sql = 'SELECT f.`name` AS `nom_film`, f.`desc_film`, f.`auteur`,  f.`date_diffusion`,  f.`date_creation`,
		group_concat(distinct c.`name` SEPARATOR "|") AS `nom_categorie`
		FROM `film` AS f
		LEFT JOIN  `film_categorie` AS fc ON fc.`id_film` = f.`id`
		LEFT JOIN  `categorie` AS c ON c.`id` = fc.`id_categorie`
		LEFT JOIN  `user` AS u ON u.`pseudo` = "'.F3::get('PARAMS.pseudo').'"
		LEFT JOIN  `film_love` AS flo ON flo.`id_user` = `u`.id
		WHERE f.`id` = flo.`id_film`
		GROUP BY f.`id`';

		$this->db->begin();
		$pr = $this->db->exec($sql);
		$this->db->commit();

		Api::response(200, $pr);
	}

	public function actionDeleteFilm(){
		$sql = 'DELETE FROM `film` WHERE `id` ='.F3::get('GET.id');

		$this->db->begin();
		$this->db->exec($sql);
		$this->db->commit();

		Api::response(200, array('valid'=>'Film bien supprime'));
	}

	public function actionUpdateFilm(){

		$name = F3::get('GET.name');
		$desc = F3::get('GET.desc_film');
		$auteur = F3::get('GET.auteur');
		$date_diffusion = F3::get('GET.date_diffusion');

		$name = ($name != "") ? '`name`="'.$name.'",' : "";
		$desc = ($desc != "") ? '`desc_film`="'.$desc.'",' : "";
		$auteur = ($auteur != "") ? '`auteur`="'.$auteur.'",' : "";
		$date_diffusion = ($date_diffusion != "") ? '`date_diffusion`="'.$date_diffusion.'",' : "";

		$suite_requete = $name.$desc.$auteur.$date_diffusion;
		$suite_requete = substr($suite_requete, 0, -1);

		$sql = "UPDATE `film` SET ".$suite_requete." WHERE `id` = ".F3::get('GET.id');

		$this->db->begin();
		$this->db->exec($sql);
		$this->db->commit();

		Api::response(200, array('valid'=>'Film bien modifie'));
	}
}