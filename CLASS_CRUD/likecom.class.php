<?php
// CRUD likecom
// ETUD
require_once __DIR__ . '../../connect/database.php';

class likecom{
	function get_1LikeCom($numMemb, $numSeqCom, $numArt){
		global $db;

		$query = 'SELECT * FROM likecom WHERE numMemb=? AND numSeqCom=? AND numArt=?;';
		$request = $db->prepare($query);
		$request->execute([$numMemb, $numSeqCom, $numArt]);
		$result = $request->fetch();

		return($result);
	}

	function get_1LikeComPlusMemb($numMemb, $numSeqCom, $numArt){
		global $db;

		$query = 'SELECT *, "" as passMemb FROM likecom INNER JOIN membre ON likecom.numMemb=membre.numMemb WHERE numMemb=?, numSeqCom=?, numArt=?;';
		$request = $db->prepare($query);
		$request->execute([$numMemb, $numSeqCom, $numArt]);
		$result = $request->fetch();

		return($result);
	}

	function get_1LikeComPlusCom($numMemb, $numSeqCom, $numArt){
		global $db;

		$query = 'SELECT * FROM likecom INNER JOIN comment ON likecom.numSeqCom=comment.numSeqCom, likecom.numArt=comment.numArt, WHERE numMemb=?, numSeqCom=?, numArt=?;';
		$request = $db->prepare($query);
		$request->execute([$numMemb, $numSeqCom, $numArt]);
		$result = $request->fetch();

		return($result);
	}

	function get_1LikeComPlusArt($numMemb, $numSeqCom, $numArt){
		global $db;

		$query = 'SELECT * FROM likecom INNER JOIN article ON likecom.numArt=article.numArt, WHERE numMemb=?, numSeqCom=?, numArt=?;';
		$request = $db->prepare($query);
		$request->execute([$numMemb, $numSeqCom, $numArt]);
		$result = $request->fetch();

		return($result);
	}

	function get_AllLikesCom(){
		global $db;
		$query = 'SELECT likecom.*, membre.pseudoMemb, article.*  FROM likecom 
				INNER JOIN membre ON likecom.numMemb=membre.numMemb
				INNER JOIN article ON likecom.numArt=article.numArt;';
		$request = $db->query($query);
		
		$allLikesCom = $request->fetchAll();

		return($allLikesCom);
	}

	function get_AllLikesComByComment($numSeqCom, $numArt){
		global $db;

		$query = 'SELECT * FROM likecom WHERE numSeqCom=?, numArt=?;';
		$request = $db->prepare($query);
		$request->execute([$numSeqCom, $numArt]);
		$result = $request->fetchAll();

		return($result);

	}

	function get_nbLikesComByComment($numSeqCom, $numArt){
		global $db;

		$query = 'SELECT * FROM likecom WHERE numSeqCom=?, numArt=?;';
		$request = $db->prepare($query);
		$request->execute([$numSeqCom, $numArt]);
		$result = $request->rowCount();

		return($result);
	}

	function get_AllLikesComByMembre($numMemb){
		global $db;

		$query = 'SELECT * FROM likecom WHERE numMemb=?;';
		$request = $db->prepare($query);
		$request->execute([$numMemb]);
		$result = $request->fetchAll();

		return($result);
	}

	function create($numMemb, $numSeqCom, $numArt, $likeC){
		global $db;

		try {
			$db->beginTransaction();

			$query = 'INSERT INTO likecom (numMemb, numSeqCom, numArt, likeC) VALUES (?, ?, ?, ?);';
			$request = $db->prepare($query);
			$request->execute( [$numMemb, $numSeqCom, $numArt, $likeC]);
			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert likecom : ' . $e->getMessage());
		}
	}

	function update($numMemb, $numSeqCom, $numArt, $likeC){
		global $db;

		try {
			$db->beginTransaction();

			$query = 'UPDATE likecom SET likeC=? WHERE numMemb=? AND numSeqCom=? AND numArt=?;';
			$request = $db->prepare($query);
			$request->execute([$likeC, $numMemb, $numSeqCom, $numArt]);

			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur update likecom : ' . $e->getMessage());
		}
	}

	// Create
	function createOrtoggle($numMemb, $numSeqCom, $numArt, $likeC=true){
		global $db;

		try {
			$db->beginTransaction();


			$query = 'INSERT INTO likecom (numMemb, numSeqCom, numArt, likeC) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE likeC = NOT likeC;';
			$request = $db->prepare($query);
			$request->execute([$numMemb, $numSeqCom, $numArt, $likeC]);

			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert Or Update likecom : ' . $e->getMessage());
		}
	}

	// AUTORISE UNIQUEMENT POUR le super-admin / admin
	function delete($numMemb, $numSeqCom, $numArt){
		global $db;
		
		try {
			$db->beginTransaction();

			$query = 'DELETE FROM likecom SET numMemb=?, numSeqCom=?, numArt=? WHERE likeArt=?;';
			$request = $db->prepare($query);
			$request->execute([$numMemb], [$numSeqCom], [$numArt]);
			$count = $request->rowCount();
			$db->commit();
			$request->closeCursor();
			return($count);
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur delete likecom : ' . $e->getMessage());
		}
	}
}	// End of class
