<?php
// CRUD likeart
// ETUD
require_once __DIR__ . '../../connect/database.php';

class likeart{
	function get_1LikeArt($numMemb, $numArt){
		global $db;

		try {
			$db->beginTransaction();
			$query = 'SELECT * FROM likeart WHERE numMemb=? AND numArt=?;';
			$request = $db->prepare($query);
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
			die('Erreur insert likeart : ' . $e->getMessage());
		}
	}
	

	function get_AllLikesArt(){
		global $db;

		$query = 'SELECT likeart.*, membre.pseudoMemb, article.libTitrArt FROM likeart 
				INNER JOIN membre ON likeart.numMemb=membre.numMemb
				INNER JOIN article ON likeart.numArt=article.numArt;';
		$request = $db->query($query);
		$allLikesArt = $request->fetchAll();
		return($allLikesArt);
	}

	function get_AllLikesArtByNumArt(){
		global $db;

		$query = 'SELECT * FROM membre ME INNER JOIN likeart LKA ON ME.numMemb = LKA.numMemb INNER JOIN article ART ON LKA.numArt = ART.numArt GROUP BY ART.numArt;';
		$result = $db->query($query);
		$allLikesArtByNumArt = $result->fetchAll();
		return($allLikesArtByNumArt);
	}

	function get_AllLikesArtByNumMemb($numMemb){
		global $db;

		// $query = 'SELECT * FROM likeart INNER JOIN article ON likeart.numArt = article.numArt WHERE numMemb=? GROUP BY likeart.numArt;';
		$query = 'SELECT * FROM likeart WHERE numMemb=? AND likeA=1;';
		$request = $db->prepare($query);
		$request->execute([$numMemb]);
		$allLikesArtByNumMemb = $request->fetchAll();

		return($allLikesArtByNumMemb);
	}

	function get_MembHasLikedArt($numMemb, $numArt){
		global $db;

		// $query = 'SELECT * FROM likeart INNER JOIN article ON likeart.numArt = article.numArt WHERE numMemb=? GROUP BY likeart.numArt;';
		$query = 'SELECT * FROM likeart WHERE numMemb=? AND numArt=? AND likeA=1';
		$request = $db->prepare($query);
		$request->execute([$numMemb, $numArt]);
		$hasLiked = $request->rowCount() > 0;

		return($hasLiked);
	}

	function get_nbLikesArtByArticle($numArt){
		global $db;

		$query = 'SELECT COUNT(*) AS nbLikes FROM likeart WHERE numArt=? AND likeA=1;';
		$request = $db->prepare($query);
		$request->execute([$numArt]);
		$allNbLikesArtByArticle = $request->fetchAll();

		return($allNbLikesArtByArticle);
	}

	function get_nbLikesArtByMembre($numMemb){
		global $db;

		$query = 'SELECT * FROM likeart WHERE numMemb=?;';
		$request = $db->prepare($query);
		$request->execute([$numMemb]);
		$allLikesArtByMembre = $request->fetchAll();
		return($result->fetchAll());
	}

	function create($numMemb, $numArt, $likeA){
		global $db;

		try {
			$db->beginTransaction();

			$query = 'INSERT INTO likeart (numMemb, numArt, likeA) VALUES (?, ?, ?);';
			$request = $db->prepare($query);
			$request->execute( [$numMemb, $numArt, $likeA]);
			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert likeart : ' . $e->getMessage());
		}
	}

	function update($numMemb, $numArt, $likeA){
		global $db;

		try {
			$db->beginTransaction();

			$query = 'UPDATE likeart SET likeA=? WHERE numMemb=? AND numArt=?;';
			$request = $db->prepare($query);
			$request->execute([$likeA, $numMemb, $numArt]);
			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur update likeart : ' . $e->getMessage());
		}
	}

	// Create et Update en même temps
	function createOrToggle($numMemb, $numArt, $likeA=true){
		global $db;

		try {
			$db->beginTransaction();

			$query = 'INSERT INTO likeart (numMemb, numArt, likeA) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE likeA = NOT likeA;';
			$request = $db->prepare($query);
			$request->execute([$numMemb, $numArt, $likeA]);

			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert Or Toggle likeart : ' . $e->getMessage());
		}
	}

	// AUTORISE UNIQUEMENT POUR le super-admin / admin => En mode DEV (avant la mise en prod)
	function delete($numMemb, $numArt){
		global $db;
		
		try {
			$db->beginTransaction();

			$query = 'DELETE FROM likeart SET numMemb=?,numArt=? WHERE likeArt=?;';
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
			die('Erreur delete likeart : ' . $e->getMessage());
		}
	}
}	// End of class
