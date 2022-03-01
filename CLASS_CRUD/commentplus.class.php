<?php
// CRUD COMMENTPLUS
// ETUD
require_once __DIR__ . '../../CONNECT/database.php';

class COMMENTPLUS{
	function get_AllCommentPlusByArticle($numArt){
		global $db;

	
		$query = 'SELECT *, "" as passMemb FROM COMMENTPLUS INNER JOIN COMMENT ON COMMENTPLUS.numSeqCom=COMMENT.numSeqCom INNER JOIN MEMBRE ON COMMENT.numMemb=MEMBRE.numMemb WHERE COMMENTPLUS.numArt=? ;';
		$request = $db->prepare($query);
		$request->execute([$numArt]);
		$allCommentsByArt = $request->fetchAll();
		return($allCommentsByArt);
	}

	function get_AllCommentPlusR(){
		global $db;

		// select
		// prepare
		// execute
		return($result->fetchAll());
	}

	function create($numSeqCom, $numArt, $numSeqComR, $numArtR){
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
			die('Erreur insert COMMENTPLUS : ' . $e->getMessage());
		}
	}
}	// End of class
