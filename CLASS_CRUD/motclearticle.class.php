<?php
// CRUD motclearticle
// ETUD
require_once __DIR__ . '../../connect/database.php';

class motclearticle{
	function get_AllMotClesByNumArt($numArt){
		global $db;

		$query = 'SELECT * FROM motclearticle INNER JOIN motcle ON motclearticle.numMotCle=motcle.numMotCle WHERE numArt=?;';
		$request = $db->prepare($query);
		$request->execute([$numArt]);
		$result = $request->fetchAll();
		return($result);
	}

	function get_AllMotClesByLibTitrArt($libTitrArt){
		global $db;

		// fonctionne à merveille
		$query = 'SELECT motcle.numMotCle, motcle.libMotCle, motcle.numLang, article.numArt FROM article INNER JOIN motclearticle ON article.numArt=motclearticle.numArt INNER JOIN motcle ON motclearticle.numMotCle=motcle.numMotCle  WHERE libTitrArt=?;';
		$request = $db->prepare($query);
		$request->execute([$libTitrArt]);
		$result = $request->fetch();
		return($result);
	}

	function get_AllArtsByNumMotCle($numMotCle){
		global $db;

		// select
		// prepare
		// execute
		return($allCommentsByArt);
	}

	function get_AllArtsByLibMotCle($libMotCle){
		global $db;

		// select
		// prepare
		// execute
		return($allCommentsByArt);
	}

	function create($numArt, $numMotCle){
		global $db;

		try {
			$db->beginTransaction();

			$query = 'INSERT INTO motclearticle (numArt, numMotCle) VALUES (?, ?);';
			$request = $db->prepare($query);
			$request->execute( [$numArt, $numMotCle]);

			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert motclearticle : ' . $e->getMessage());
		}
	}

	function delete($numArt, $numMotCle){
		global $db;

		try {
			$db->beginTransaction();

			$query = 'DELETE FROM motclearticle WHERE `numArt` = ? AND `numMotCle` = ?;';
			$request = $db->prepare($query);
			$request->execute([$numArt, $numMotCle]);
			$count = $request->rowCount();

			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur delete motclearticle : ' . $e->getMessage());
		}
	}
}	// End of class
