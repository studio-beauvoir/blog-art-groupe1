<?php
// CRUD article
// ETUD
require_once __DIR__ . '/../connect/database.php';

class article{

	function get_AllByMotCle($motcle){
        global $db;
        $query = "SELECT motcle.*, motclearticle.*, article.numArt,article.libTitrArt, article.libChapoArt, article.urlPhotArt FROM motcle 
            JOIN motclearticle ON motcle.numMotCle = motclearticle.numMotCle
            JOIN article ON motclearticle.numArt = article.numArt
            WHERE motcle.libMotCle LIKE ? ";
        $request = $db->prepare($query);
		$request->execute([$motcle]);
        $articles = $request->fetchAll();
        return $articles;
    }

	function get_1Article($numArt){
		global $db;
		
		try {
			// $query = 'SELECT * FROM article WHERE numArt=?;';
			$query = 'SELECT article.*, SUM(likeart.likeA) AS nbLikes FROM article
					LEFT JOIN likeart ON likeart.numArt=article.numArt WHERE article.numArt=?
					GROUP BY article.numArt';
			$request = $db->prepare($query);
			
			$request->execute([$numArt]);

			$result = $request->fetch();

			if(isset($request)) {
				return($result);
			} else {
				throw new ErrorException('Article not found');
			}
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur get 1 membre : ' . $e->getMessage());
		}
	}

	//ça j'ai AP
	// function get_1ArticleAnd3FK($numArt){
	// 	global $db;

	// 	// select
	// 	// prepare
	// 	// execute
	// 	return($result->fetch());
	// }

	function get_AllArticles(){
		global $db;
		
		$query = 'SELECT * FROM article INNER JOIN thematique ON article.numThem = thematique.numThem INNER JOIN angle ON article.numAngl=angle.numAngl;';
		$request = $db->query($query);
		$allArticles = $request->fetchAll();
		return($allArticles);
	}

	function get_AllArticlesByNumAnglNumThem(){
		global $db;

		$query = 'SELECT * FROM article WHERE numAngl=?, numThem=?;';
		$result = $db->query($query);
		$allArticlesByNumAnglNumThem = $result->fetchAll();
		return($allArticlesByNumAnglNumThem);
	}

	function get_NbAllArticlesByNumAngl($numAngl){
		global $db;

		$db->beginTransaction();

		$query = 'SELECT * FROM article WHERE numAngl=?;';
		$request = $db->prepare($query);
		
		$request->execute([$numAngl]);

		// $db->commit();
		// execute
		$allArticlesBynumAngl = $request->fetchAll(); // [...,  ...]
		
		$db->commit();
		$request->closeCursor();
		
		$allNbArticlesBynumAngl = count($allArticlesBynumAngl); 
		return($allNbArticlesBynumAngl);
	}

	function get_NbAllArticlesByNumThem($numThem){
		global $db;

		$db->beginTransaction();

		$query = 'SELECT * FROM article WHERE numThem=?;';
		$request = $db->prepare($query);
		
		$request->execute([$numThem]);

		// $db->commit();
		// execute
		$allArticlesBynumThem = $request->fetchAll(); // [...,  ...]
		
		$db->commit();
		$request->closeCursor();
		
		$allNbArticlesBynumThem = count($allArticlesBynumThem); 
		return($allNbArticlesBynumThem);
	}

	// Barre de recherche CONCAT : mots clés dans article & thematique
	function get_ArticlesByMotsCles($motcle){
		global $db;

		// Recherche plusieurs mots clés (CONCAT)
		$textQuery = 'SELECT * FROM article AR INNER JOIN thematique TH ON AR.numThem = TH.numThem WHERE CONCAT(libTitrArt, libChapoArt, libAccrochArt, parag1Art, libSsTitr1Art, parag2Art, libSsTitr2Art, parag3Art, libConclArt, libThem) LIKE "%'.$motcle.'%" ORDER BY numArt DESC';
		$result = $db->query($textQuery);
		$allArticlesByMotsCles = $result->fetchAll();
		return($allArticlesByMotsCles);
	}

	// Barre de recherche JOIN : mots clés par motcle (TJ) dans article
	function get_MotsClesByArticles($listMotcles){
		global $db;

		/*
		Requete avec IN :
		SELECT * FROM motcle WHERE libMotCle IN ('Bordeaux', 'bleu');
		*/
		// Recherche mot clé (INNER JOIN) dans tables motcle & (article)
		$textQuery = 'SELECT AR.numArt, libTitrArt, libChapoArt, libAccrochArt, parag1Art, libSsTitr1Art, parag2Art, libSsTitr2Art, parag3Art, libConclArt FROM motcle MC INNER JOIN motclearticle MCA ON MC.numMotCle = MCA.numMotCle INNER JOIN article AR ON MCA.numArt = AR.numArt WHERE libMotCle IN (' . $listMotcles . ');';
		$result = $db->prepare($textQuery);
		$result->execute([$listMotcles]);
		$allArticlesByNumAnglNumThem = $result->fetchAll();
		return($allArticlesByNumAnglNumThem);
	}

	// Fonction pour recupérer la prochaine PK de la table article
	function getNextNumArt() {
		global $db;

		$requete = "SELECT MAX(numArt) AS numArt FROM article;";
		$result = $db->query($requete);

		if ($result) {
			$tuple = $result->fetch();
			$numArt = $tuple["numArt"];
			// No PK suivante article
			$numArt++;
		}   // End of if ($result)
		return $numArt;
	} // End of function

	// Fonction pour recupérer la dernière PK de article
	// avant insert des n occurr dans TJ motclearticle
	function get_LastNumArt(){
		global $db;

		$requete = "SELECT MAX(numArt) AS numArt FROM article;";
		$result = $db->query($requete);

		if ($result) {
			$tuple = $result->fetch();
			$lastNumArt = $tuple["numArt"];

		}   // End of if ($result)
		return $lastNumArt;
	} // End of function

	function create($dtCreArt, $libTitrArt, $libChapoArt, $libAccrochArt, $parag1Art, $libSsTitr1Art, $parag2Art, $libSsTitr2Art, $parag3Art, $libConclArt, $urlPhotArt, $numAngl, $numThem){
		global $db;

		try {
			$db->beginTransaction();

			$query = 'INSERT INTO article (dtCreArt, libTitrArt, libChapoArt, libAccrochArt, parag1Art, libSsTitr1Art, parag2Art, libSsTitr2Art, parag3Art, libConclArt, urlPhotArt, numAngl, numThem) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);';
			$request = $db->prepare($query);
			$request->execute([$dtCreArt, $libTitrArt, $libChapoArt, $libAccrochArt, $parag1Art, $libSsTitr1Art, $parag2Art, $libSsTitr2Art, $parag3Art, $libConclArt, $urlPhotArt, $numAngl, $numThem]);
			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert article : ' . $e->getMessage());
		}
	}

	function update($numArt, $libTitrArt, $libChapoArt, $libAccrochArt, $parag1Art, $libSsTitr1Art, $parag2Art, $libSsTitr2Art, $parag3Art, $libConclArt, $urlPhotArt, $numAngl, $numThem){
		global $db;

		try {
			$db->beginTransaction();
			
			$query = 'UPDATE article SET libTitrArt=?, libChapoArt=?, libAccrochArt=?, parag1Art=?, libSsTitr1Art=?, parag2Art=?, libSsTitr2Art=?, parag3Art=?, libConclArt=?, urlPhotArt=?, numAngl=?, numThem=? WHERE numArt=?;';
			$request = $db->prepare($query);
			$request->execute([$libTitrArt, $libChapoArt, $libAccrochArt, $parag1Art, $libSsTitr1Art, $parag2Art, $libSsTitr2Art, $parag3Art, $libConclArt, $urlPhotArt, $numAngl, $numThem, $numArt]);
			$db->commit();
			$request->closeCursor(); 
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur update article : ' . $e->getMessage());
		}
	}

	function delete($numArt){
		global $db;

		try {
			$db->beginTransaction();

			$query = 'DELETE FROM article WHERE `numArt` = ?;';
			$request = $db->prepare($query);
			$request->execute([$numArt]);
			$count = $request->rowCount();
			$db->commit();
			$request->closeCursor();
			return($count);
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur delete article : ' . $e->getMessage());
		}
	}
}	// End of class
