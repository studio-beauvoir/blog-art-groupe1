<?php
// CRUD LIKECOM
// ETUD
require_once __DIR__ . '../../CONNECT/database.php';

class LIKECOM{
	function get_1LikeCom($numMemb, $numSeqCom, $numArt){
		global $db;

		$query = 'SELECT * FROM LIKECOM WHERE numMemb=?, numSeqCom=?, numArt=?;';
		$request = $db->prepare($query);
		$request->execute([$numMemb, $numSeqCom, $numArt]);
		$result = $request->fetch();

		return($result);
	}

	function get_1LikeComPlusMemb($numMemb, $numSeqCom, $numArt){
		global $db;

		$query = 'SELECT *, "" as passMemb FROM LIKECOM INNER JOIN MEMBRE ON LIKECOM.numMemb=MEMBRE.numMemb WHERE numMemb=?, numSeqCom=?, numArt=?;';
		$request = $db->prepare($query);
		$request->execute([$numMemb, $numSeqCom, $numArt]);
		$result = $request->fetch();

		return($result);
	}

	function get_1LikeComPlusCom($numMemb, $numSeqCom, $numArt){
		global $db;

		$query = 'SELECT * FROM LIKECOM INNER JOIN COMMENT ON LIKECOM.numSeqCom=COMMENT.numSeqCom, LIKECOM.numArt=COMMENT.numArt, WHERE numMemb=?, numSeqCom=?, numArt=?;';
		$request = $db->prepare($query);
		$request->execute([$numMemb, $numSeqCom, $numArt]);
		$result = $request->fetch();

		return($result);
	}

	function get_1LikeComPlusArt($numSeqCom, $numArt){
		global $db;

		$query = 'SELECT * FROM LIKECOM INNER JOIN ARTICLE ON LIKECOM.numArt=ARTICLE.numArt, WHERE numMemb=?, numSeqCom=?, numArt=?;';
		$request = $db->prepare($query);
		$request->execute([$numMemb, $numSeqCom, $numArt]);
		$result = $request->fetch();

		return($result);
	}

	function get_AllLikesCom(){
		global $db;

		$query = 'SELECT * FROM LIKECOM';
		$request = $db->query($query);
		$allLikesCom = $request->fetchAll();

		return($allLikesCom);
	}

	function get_AllLikesComByComment($numSeqCom, $numArt){
		global $db;

		$query = 'SELECT * FROM LIKECOM WHERE numSeqCom=?, numArt=?;';
		$request = $db->prepare($query);
		$request->execute([$numSeqCom, $numArt]);
		$result = $request->fetchAll();

		return($result);

	}

	function get_nbLikesComByComment($numSeqCom, $numArt){
		global $db;

		$query = 'SELECT * FROM LIKECOM WHERE numSeqCom=?, numArt=?;';
		$request = $db->prepare($query);
		$request->execute([$numSeqCom, $numArt]);
		$result = $request->rowCount();

		return($result);
	}

	function get_AllLikesComByMembre($numMemb){
		global $db;

		$query = 'SELECT * FROM LIKECOM WHERE numMemb=?;';
		$request = $db->prepare($query);
		$request->execute([$numMemb]);
		$result = $request->fetchAll();

		return($result);
	}

	function create($numMemb, $numSeqCom, $numArt, $likeC){
		global $db;

		try {
			$db->beginTransaction();

			// insert
			// prepare
			// execute
			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert LIKECOM : ' . $e->getMessage());
		}
	}

	function update($numMemb, $numSeqCom, $numArt, $likeC){
		global $db;

		try {
			$db->beginTransaction();

			// update
			// prepare
			// execute
			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur update LIKECOM : ' . $e->getMessage());
		}
	}

	// Create et Update en même temps
	function createOrUpdate($numMemb, $numSeqCom, $numArt){
		global $db;

		try {
			$db->beginTransaction();

			// insert / update
			// prepare
			// execute
			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert Or Update LIKECOM : ' . $e->getMessage());
		}
	}

	// AUTORISE UNIQUEMENT POUR le super-admin / admin
	function delete($numMemb, $numSeqCom, $numArt){
		global $db;
		
		try {
			$db->beginTransaction();

			// delete
			// prepare
			// execute
			//$count = $request->rowCount();
			$db->commit();
			$request->closeCursor();
			//return($count);
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur delete LIKECOM : ' . $e->getMessage());
		}
	}
}	// End of class
