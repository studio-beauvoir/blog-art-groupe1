<?php
// CRUD thematique
// ETUD
require_once __DIR__ . '../../connect/database.php';

class thematique{
	function get_1Thematique($numThem){
		global $db;

		try {
			$query = 'SELECT * FROM thematique WHERE numThem=?;';
			$request = $db->prepare($query);
			
			$request->execute([$numThem]);

			$result = $request->fetch();

			if(isset($request)) {
				return($result);
			} else {
				throw new ErrorException('Thematique not found');
			}
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert thematique : ' . $e->getMessage());
		}
	}

	function get_1ThematiqueByLang($numThem){
		global $db;

		// select
		$query = 'SELECT * FROM thematique WHERE numLang=?;';
		// prepare
		$request = $db->prepare($query);
		// execute
		$request->execute([$numThem]);
		$result = $request->fetch();
		return($result);
	}

	function get_AllThematiques(){
		global $db;

		$query = 'SELECT * FROM thematique INNER JOIN langue ON thematique.numLang=langue.numLang;';
		$request = $db->query($query);
		$allThematiques = $request->fetchAll();

		return($allThematiques);
	}

	function get_AllThematiquesByLang($numLang){
		global $db;

		$query = 'SELECT * FROM thematique WHERE numLang=?;';
		$request = $db->prepare($query);
		$request->execute([$numLang]);
		$allThematiquesByLang = $request->fetchAll();
		return($allThematiquesByLang);
	}

	//HELP HERE
	// à verif ------------------------------------------------------------------------------------------------------- !!!
	function get_NbAllThematiquesBynumLang($numLang){ 
		global $db;

		$db->beginTransaction();
		
		$query = 'SELECT COUNT (*) FROM thematique WHERE numLang=?';
		$request = $db->prepare($query);
		$request->execute([$numLang]);
		$allNbThematiquesBynumLang = $request->fetch();

		$db->commit();
		$request->closeCursor();

		return($allNbThematiquesBynumLang); 
	}

	// Récup dernière PK NumThem
	function getNextNumThem($numLang) {
		global $db;
	
		// Découpage FK langue
		$libLangSelect = substr($numLang, 0, 4);
		$parmNumLang = $libLangSelect . '%';
	
		$requete = "SELECT MAX(numLang) AS numLang FROM thematique WHERE numLang LIKE '$parmNumLang';";
		$result = $db->query($requete);
	
		if ($result) {
			$tuple = $result->fetch();
			$numLang = $tuple["numLang"];
			if (is_null($numLang)) {    // New lang dans thematique
				// Récup dernière PK utilisée
				$requete = "SELECT MAX(numThem) AS numThem FROM thematique;";
				$result = $db->query($requete);
				$tuple = $result->fetch();
				$numThem = $tuple["numThem"];
	
				$numThemSelect = (int)substr($numThem, 4, 2);
				// No séquence suivant langue
				$numSeq1Them = $numThemSelect + 1;
				// Init no séquence thematique pour nouvelle lang
				$numSeq2Them = 1;
			} else {
				// Récup dernière PK pour FK sélectionnée
				$requete = "SELECT MAX(numThem) AS numThem FROM thematique WHERE numLang LIKE '$parmNumLang' ;";
				$result = $db->query($requete);
				$tuple = $result->fetch();
				$numThem = $tuple["numThem"];
	
				// No séquence actuel langue
				$numSeq1Them = (int)substr($numThem, 4, 2);
				// No séquence actuel langue
				$numSeq2Them = (int)substr($numThem, 6, 2);
				// No séquence suivant thematique
				$numSeq2Them++;
			}
	
			$libThemSelect = "THEM";
			// PK reconstituée : THE + no seq langue
			if ($numSeq1Them < 10) {
				$numThem = $libThemSelect . "0" . $numSeq1Them;
			} else {
				$numThem = $libThemSelect . $numSeq1Them;
			}
			// PK reconstituée : THE + no seq langue + no seq thématique
			if ($numSeq2Them < 10) {
				$numThem = $numThem . "0" . $numSeq2Them;
			} else {
				$numThem = $numThem . $numSeq2Them;
			}
		}   // End of if ($result) / no seq langue
		return $numThem;
	} // End of function

	function create($numThem, $libThem, $numLang){
		global $db;

		try {
			$db->beginTransaction();

			$query = 'INSERT INTO thematique (numThem, libThem, numLang) VALUES (?, ?, ?);';
			$request = $db->prepare($query);
			$request->execute( [$numThem, $libThem, $numLang]);
			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert thematique : ' . $e->getMessage());
		}
	}

	function update($numThem, $libThem, $numLang){
		global $db;

		try {
			$db->beginTransaction();

			$query = 'UPDATE thematique SET libThem=?,numlang=? WHERE numThem=?;';
			$request = $db->prepare($query);
			$request->execute([$libThem, $numLang, $numThem]);
			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur update thematique : ' . $e->getMessage());
		}
	}

	// Ctrl FK sur thematique, angle, motcle avec del
	function delete($numThem){
		global $db;
		
		try {
			$db->beginTransaction();

			$query = 'DELETE FROM thematique WHERE `numThem` = ?;';
			$request = $db->prepare($query);
			$request->execute([$numThem]);
			$count = $request->rowCount();
			$db->commit();
			$request->closeCursor();
			return($count);
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur delete thematique : ' . $e->getMessage());
		}
	}
}		// End of class
