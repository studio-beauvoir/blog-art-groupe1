<?php
// CRUD commentplus
// ETUD
require_once __DIR__ . '../../connect/database.php';

class commentplus{
	function get_1CommentPlus($numSeqCom){
		global $db;

		$query = 'SELECT * FROM commentplus WHERE numSeqCom=?;';
		$request = $db->prepare($query);
		$request->execute([$numSeqCom]);
		$result = $request->fetch();

		return($result);
	}

	function get_AllCommentPlusByArticle($numArt){
		global $db;

	
		// $query = 'SELECT comment.*, commentplus.*, membre.pseudoMemb FROM commentplus INNER JOIN comment ON commentplus.numSeqCom=comment.numSeqCom INNER JOIN membre ON comment.numMemb=membre.numMemb WHERE commentplus.numArt=? ;';
		// $query = 	'SELECT comment.*, membre.pseudoMemb, COUNT(likecom.numSeqCom) AS nblike FROM comment
		// 			JOIN membre ON comment.numMemb=membre.numMemb
		// 			LEFT JOIN likecom ON likecom.numSeqCom=comment.numSeqCom WHERE (likecom.numArt=comment.numArt OR comment.numArt=?)
		// 			GROUP BY comment.numSeqCom;';

		$query = 'SELECT * FROM commentplus WHERE numArt=? ;';

		$request = $db->prepare($query);
		$request->execute([$numArt]);
		$allCommentsByArt = $request->fetchAll();
		return($allCommentsByArt);
	}

	function get_AllCommentPlus(){
		global $db;
		$query = 'SELECT * FROM commentplus INNER JOIN article ON commentplus.numArt=article.numArt;';
		$request = $db->query($query);
		$allCommentPlus = $request->fetchAll();

		return($allCommentPlus);
	}

	function get_AllCommentPlusR(){
		global $db;

		// select
		// prepare
		// execute
		// return($result->fetchAll());
	}

	function create($numSeqCom, $numArt, $numSeqComR, $numArtR){
		global $db;
		
		try {
			$db->beginTransaction();

			$query = 'INSERT INTO commentplus (numSeqCom, numArt, numSeqComR, numArtR) VALUES (?, ?, ?, ?);';
			$request = $db->prepare($query);
			$request->execute( [$numSeqCom, $numArt, $numSeqComR, $numArtR]);
			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert commentplus : ' . $e->getMessage());
		}
	}

	function delete($numSeqCom){
		global $db;

		try {
			$db->beginTransaction();

			// delete
			$query = 'DELETE FROM commentplus WHERE `numSeqCom` = ?;';
			// prepare
			$request = $db->prepare($query);
			// execute
			$request->execute([$numSeqCom]);
			$count = $request->rowCount();
			$db->commit();
			$request->closeCursor();
			return($count);
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur delete commentplus : ' . $e->getMessage());
		}
	}
}	// End of class
