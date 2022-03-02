<?php
// CRUD COMMENT
// ETUD
require_once __DIR__ . '../../connect/database.php';

require_once __DIR__ . './likecom.class.php';

$monLikecom = new LIKECOM();

class COMMENT{
	function get_1Comment($numSeqCom, $numArt){
		global $db;
		
		// $query = 'SELECT * FROM COMMENT WHERE numArt=? AND numSeqCom=?;';
		$query = 	'SELECT comment.*, membre.pseudoMemb, SUM(likecom.likeC) AS nblike FROM comment
					JOIN membre ON comment.numMemb=membre.numMemb
					LEFT JOIN likecom ON likecom.numSeqCom=comment.numSeqCom WHERE (likecom.numArt=comment.numArt OR comment.numArt=?) AND comment.numSeqCom=?
					GROUP BY comment.numSeqCom;';

		$request = $db->prepare($query);
		
		$request->execute([$numArt, $numSeqCom]);

		$result = $request->fetch();

		if(isset($request)) {
			return($result);
		} else {
			throw new ErrorException('Comment not found');
		}
	}

	function get_AllComments() {
		global $db;

		$query = 'SELECT *, "" as passMemb FROM COMMENT INNER JOIN MEMBRE ON COMMENT.numMemb=MEMBRE.numMemb;';
		$result = $db->query($query);
		$allComments = $result->fetchAll();

		return($allComments);
	}

	function get_AllCommentsByNumArt($numArt){
		global $db;

		// $query = 'SELECT *, "" as passMemb FROM COMMENT INNER JOIN MEMBRE ON COMMENT.numMemb=MEMBRE.numMemb WHERE numArt=?;';
		$query = 	'SELECT comment.*, membre.pseudoMemb, SUM(likecom.likeC) AS nblike FROM comment
					JOIN membre ON comment.numMemb=membre.numMemb
					LEFT JOIN likecom ON likecom.numSeqCom=comment.numSeqCom WHERE (likecom.numArt=comment.numArt OR comment.numArt=?)
					GROUP BY comment.numSeqCom;';
		$request = $db->prepare($query);
		$request->execute([$numArt]);
		$allCommentsByArt = $request->fetchAll();

		return($allCommentsByArt);
	}
	//FIN DE LA PARTIE CHELOUE--------------------------------------

	function get_1CommentsByNumSeqComNumArt($numSeqCom, $numArt){
		global $db;

		// select
		$query = 'SELECT * FROM COMMENT WHERE numSeqCom=?, numArt=?;';
		// prepare
		$request = $db->prepare($query);
		// execute
		$request->execute([$numSeqCom, $numArt]);
		$result = $request->fetch();
		return($result);
	}

	function get_AllCommentsByNumSeqComNumArt($numSeqCom, $numArt){
		global $db;

		$query = 'SELECT * FROM COMMENT WHERE numSeqCom=?, numArt=?;';
		$result = $db->query($query);
		$allCommentsByNumSeqComNumArt = $result->fetchAll();
		return($allCommentsByNumSeqComNumArt);
	}

	function get_AllCommentsByArticleByMemb(){
		global $db;

		$query = 'SELECT * FROM COMMENT WHERE numMemb=?;';
		$result = $db->query($query);
		$allCommentsByArticleByMemb = $result->fetchAll();
		return($allCommentsByArticleByMemb);
	}

	function get_NbAllCommentsBynumMemb($numMemb){
		global $db;

		$query = 'SELECT COUNT (*) FROM COMMENT WHERE numMemb=?;';
		$request = $db->prepare($query);
		$request->execute([$numMemb]);
		$allNbAllCommentsBynumMemb = $request->fetch();

		
		return($allNbAllCommentsBynumMemb);
	}

	// Fonction : recupérer next numéro séquence de article recherché (PK COMMENT)
	// Commentaire suivant sur un article
	// => Pour table COMMENT & table COMMENTPLUS
	function getNextNumCom($numArt) {
		global $db;

		//récup id de l'article et num séquence comment
		$queryText = "SELECT CO.numArt, MAX(numSeqCom) AS numSeqCom FROM ARTICLE AR INNER JOIN COMMENT CO ON AR.numArt = CO.numArt WHERE AR.numArt = ?;";
		$result = $db->prepare($queryText);
		$result->execute(array($numArt));

		if ($result) {
			$tuple = $result->fetch();
			$numArtCom = $tuple["numArt"];
			$numSeqCom = $tuple["numSeqCom"];
			// New comment dans COMMENT ou REPONSE pour ARTICLE
			if (is_null($numArtCom)) { // si l'id de l'article est null
				// Init no séquence
				$numSeqCom = 1; //première fois qu'on rentre un commentaire pour cet article
			} else {
			if ((!is_null($numArtCom)) AND (!is_null($numSeqCom))) { //si num de sequence existe alors numéro de séquence++
				// No séquence suivant
				$numSeqCom++;
			} else {
				// Pbl cohérence select NumArt & NumCom
				return -1;
			}
			}
			return $numSeqCom;
		}   // End of if ($result)
		else {
		return -1;  // Pbl select / BDD
		}
	} // End of function

	// comment en attente : Moderation affComOK à FALSE
	function create($numSeqCom, $numArt, $libCom, $numMemb){
		global $db;

		try {
			$db->beginTransaction();

			$query = 'INSERT INTO COMMENT (numSeqCom, numArt, dtCreCom, dtModCom, libCom, attModOK, numMemb) VALUES (?, ?, NOW(), NOW(), ?, 0, ?);';
			$request = $db->prepare($query);
			$request->execute( [$numSeqCom, $numArt, $libCom, $numMemb]);
			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert COMMENT : ' . $e->getMessage());
		}
	}

	// Moderation : TRUE si comment affiché, FALSE sinon
	// et remarques possibles admin si non affiché
	function update($numSeqCom, $numArt, $attModOK, $notifComKOAff, $delLogiq){
		global $db;

		try {
			$db->beginTransaction();

			$query = 'UPDATE COMMENT SET numSeqCom=?, numArt=?, attModOK=?, dtModCom=NOW(), notifComKOAff=?, delLogiq=? WHERE numSeqCom=? AND numArt=?';
			$request = $db->prepare($query);
			$request->execute([$attModOK, $notifComKOAff, $delLogiq, $numSeqCom, $numArt]);
			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur update COMMENT : ' . $e->getMessage());
		}
	}

	// A priori : del comment impossible (sauf si choix admin après modération) => Cf. createOrUpdate() ci-dessus
	function delete($numSeqCom, $numArt){	// OU à utiliser pour del logique : del => update
		global $db;

		try {
			$db->beginTransaction();

			$query = 'DELETE FROM COMMENT WHERE numSeqCom=? AND numArt=?;';
			$request = $db->prepare($query);
			$request->execute([$numSeqCom, $numArt]);
			$count = $request->rowCount();
			$db->commit();
			$request->closeCursor();
			return($count);
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur delete COMMENT : ' . $e->getMessage());
		}
	}
}	// End of class
