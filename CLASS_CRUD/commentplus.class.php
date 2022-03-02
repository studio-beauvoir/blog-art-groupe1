<?php
// CRUD COMMENTPLUS
// ETUD
require_once __DIR__ . '../../connect/database.php';

class COMMENTPLUS{
	function get_AllCommentPlusByArticle($numArt){
		global $db;

	
		// $query = 'SELECT comment.*, commentplus.*, membre.pseudoMemb FROM COMMENTPLUS INNER JOIN COMMENT ON COMMENTPLUS.numSeqCom=COMMENT.numSeqCom INNER JOIN MEMBRE ON COMMENT.numMemb=MEMBRE.numMemb WHERE COMMENTPLUS.numArt=? ;';
		// $query = 	'SELECT comment.*, membre.pseudoMemb, COUNT(likecom.numSeqCom) AS nblike FROM comment
		// 			JOIN membre ON comment.numMemb=membre.numMemb
		// 			LEFT JOIN likecom ON likecom.numSeqCom=comment.numSeqCom WHERE (likecom.numArt=comment.numArt OR comment.numArt=?)
		// 			GROUP BY comment.numSeqCom;';

		$query = 'SELECT * FROM COMMENTPLUS WHERE numArt=? ;';

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

			$query = 'INSERT INTO COMMENTPLUS (numSeqCom, numArt, numSeqComR, numArtR) VALUES (?, ?, ?, ?);';
			$request = $db->prepare($query);
			$request->execute( [$numSeqCom, $numArt, $numSeqComR, $numArtR]);
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
