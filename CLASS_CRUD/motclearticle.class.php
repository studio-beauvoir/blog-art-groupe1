<?php
// CRUD MOTCLEARTICLE
// ETUD
require_once __DIR__ . '../../CONNECT/database.php';

class MOTCLEARTICLE{
	function get_AllMotClesByNumArt($numArt){
		global $db;

		$query = 'SELECT * FROM MOTCLEARTICLE INNER JOIN MOTCLE ON MOTCLEARTICLE.numMotCle=MOTCLE.numMotCle WHERE numArt=?;';
		$request = $db->prepare($query);
		$request->execute([$numArt]);
		$result = $request->fetchAll();
		return($result);
	}

	function get_AllMotClesByLibTitrArt($libTitrArt){
		global $db;

		// fonctionne à merveille
		$query = 'SELECT MOTCLE.numMotCle, MOTCLE.libMotCle, MOTCLE.numLang, ARTICLE.numArt FROM ARTICLE INNER JOIN MOTCLEARTICLE ON ARTICLE.numArt=MOTCLEARTICLE.numArt INNER JOIN MOTCLE ON MOTCLEARTICLE.numMotCle=MOTCLE.numMotCle  WHERE libTitrArt=?;';
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

			$query = 'INSERT INTO MOTCLEARTICLE (numArt, numMotCle) VALUES (?, ?);';
			$request = $db->prepare($query);
			$request->execute( [$numArt, $numMotCle]);

			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert MOTCLEARTICLE : ' . $e->getMessage());
		}
	}

	function delete($numArt, $numMotCle){
		global $db;

		try {
			$db->beginTransaction();

			$query = 'DELETE FROM MOTCLEARTICLE WHERE `numArt` = ? AND `numMotCle` = ?;';
			$request = $db->prepare($query);
			$request->execute([$numArt, $numMotCle]);
			$count = $request->rowCount();

			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur delete MOTCLEARTICLE : ' . $e->getMessage());
		}
	}
}	// End of class
