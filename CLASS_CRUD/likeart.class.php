<?php
// CRUD LIKEART
// ETUD
require_once __DIR__ . '../../connect/database.php';

class LIKEART{
	function get_1LikeArt($numMemb, $numArt){
		global $db;

		try {
			$db->beginTransaction();
			$query = 'SELECT * FROM LIKEART WHERE numMemb=?, numArt=?;';
			$request = $db->prepare($query);
			var_dump([$numMemb, $numArt]);
			$request->execute([$numMemb, $numArt]);

			$result = $request->fetch();

			if(isset($request)) {
				return($result);
			} else {
				throw new ErrorException('LikeArt not found');
			}
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert LIKEART : ' . $e->getMessage());
		}
	}
	

	function get_AllLikesArt(){
		global $db;

		$query = 'SELECT * FROM LIKEART INNER JOIN MEMBRE ON LIKEART.numMemb=MEMBRE.numMemb;';
		$request = $db->query($query);
		$allLikesArt = $request->fetchAll();
		return($allLikesArt);
	}

	function get_AllLikesArtByNumArt(){
		global $db;

		$query = 'SELECT * FROM MEMBRE ME INNER JOIN LIKEART LKA ON ME.numMemb = LKA.numMemb INNER JOIN ARTICLE ART ON LKA.numArt = ART.numArt GROUP BY ART.numArt;';
		$result = $db->query($query);
		$allLikesArtByNumArt = $result->fetchAll();
		return($allLikesArtByNumArt);
	}

	function get_AllLikesArtByNumMemb($numMemb){
		global $db;

		// $query = 'SELECT * FROM LIKEART INNER JOIN ARTICLE ON LIKEART.numArt = ARTICLE.numArt WHERE numMemb=? GROUP BY LIKEART.numArt;';
		$query = 'SELECT * FROM LIKEART WHERE numMemb=? AND likeA=1;';
		$request = $db->prepare($query);
		$request->execute([$numMemb]);
		$allLikesArtByNumMemb = $request->fetchAll();

		return($allLikesArtByNumMemb);
	}

	function get_MembHasLikedArt($numMemb, $numArt){
		global $db;

		// $query = 'SELECT * FROM LIKEART INNER JOIN ARTICLE ON LIKEART.numArt = ARTICLE.numArt WHERE numMemb=? GROUP BY LIKEART.numArt;';
		$query = 'SELECT * FROM LIKEART WHERE numMemb=? AND numArt=? AND likeA=1';
		$request = $db->prepare($query);
		$request->execute([$numMemb, $numArt]);
		$hasLiked = $request->rowCount() > 0;

		return($hasLiked);
	}

	function get_nbLikesArtByArticle($numArt){
		global $db;

		$query = 'SELECT COUNT(*) AS nbLikes FROM LIKEART WHERE numArt=? AND likeA=1;';
		$request = $db->prepare($query);
		$request->execute([$numArt]);
		$allNbLikesArtByArticle = $request->fetchAll();

		return($allNbLikesArtByArticle);
	}

	function get_nbLikesArtByMembre($numMemb){
		global $db;

		$query = 'SELECT * FROM LIKEART WHERE numMemb=?;';
		$request = $db->prepare($query);
		$request->execute([$numMemb]);
		$allLikesArtByMembre = $request->fetchAll();
		return($result->fetchAll());
	}

	function create($numMemb, $numArt, $likeA){
		global $db;

		try {
			$db->beginTransaction();

			$query = 'INSERT INTO LIKEART (numMemb, numArt, likeA) VALUES (?, ?, ?);';
			$request = $db->prepare($query);
			$request->execute( [$numMemb, $numArt, $likeA]);
			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert LIKEART : ' . $e->getMessage());
		}
	}

	function update($numMemb, $numArt, $likeA){
		global $db;

		try {
			$db->beginTransaction();

			$query = 'UPDATE LIKEART SET numMemb=?,numArt=? WHERE likeArt=?;';
			$request = $db->prepare($query);
			$request->execute([$numMemb, $numArt, $likeA]);
			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur update LIKEART : ' . $e->getMessage());
		}
	}

	// Create et Update en même temps
	function createOrToggle($numMemb, $numArt, $likeA=true){
		global $db;

		try {
			$db->beginTransaction();

			$query = 'INSERT INTO LIKEART (numMemb, numArt, likeA) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE likeA = NOT likeA;';
			$request = $db->prepare($query);
			$request->execute([$numMemb, $numArt, $likeA]);

			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert Or Toggle LIKEART : ' . $e->getMessage());
		}
	}

	// AUTORISE UNIQUEMENT POUR le super-admin / admin => En mode DEV (avant la mise en prod)
	function delete($numMemb, $numArt){
		global $db;
		
		try {
			$db->beginTransaction();

			$query = 'DELETE FROM LIKEART SET numMemb=?,numArt=? WHERE likeArt=?;';
			$request = $db->prepare($query);
			$request->execute([$numMemb], [$numArt]);
			$count = $request->rowCount();
			$db->commit();
			$request->closeCursor();
			return($count);
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur delete LIKEART : ' . $e->getMessage());
		}
	}
}	// End of class
