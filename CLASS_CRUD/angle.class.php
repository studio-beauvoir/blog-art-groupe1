<?php
// CRUD ANGLE
// ETUD
require_once __DIR__ . '../../CONNECT/database.php';

class ANGLE{
	function get_1Angle(string $numAngl) {
		global $db;

		try {
			$query = 'SELECT * FROM ANGLE WHERE numAngl=?;';
			$request = $db->prepare($query);
			
			$request->execute([$numAngl]);

			$result = $request->fetch();

			if(isset($request)) {
				return($result);
			} else {
				throw new ErrorException('Angle not found');
			}
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert ANGLE : ' . $e->getMessage());
		}
	}

	function get_1AngleByLang(string $numAngl) {
		global $db;

		$query = 'SELECT * FROM THEMATIQUE WHERE numAngl=?;';
		$request = $db->prepare($query);
		$request->execute([$numAngl]);
		$result = $request->fetch();
		return($result->fetch());
	}

	function get_AllAngles() {
		global $db;

		$query = 'SELECT * FROM ANGLE;';
		$request = $db->query($query);
		$allAngles = $request->fetchAll();
		return($allAngles);
	}

	function get_AllAnglesByLang() {
		global $db;
		$query = 'SELECT * FROM ANGLE WHERE numAngl=?;';
		$result = $db->query($query);
		$allAnglesByLang = $result->fetchAll();
		return($allAnglesByLang);
	}

	function get_NbAllAnglesBynumAngl(string $numAngl) {
		global $db;

		$db->beginTransaction();

		$query = 'SELECT COUNT (*) FROM ANGLE WHERE numAngl=?;';
		$request = $db->prepare($query);
		$request->execute([$numAngl]);
		$allNbAnglesBynumAngl = $request->fetch();

		$db->commit();
		$request->closeCursor();
		
		return($allNbAnglesBynumAngl);
	}

	//  Récupérer la prochaine PK de la table ANGLE
	function getNextNumAngl($numAngl) {
		global $db;
	
		// Découpage FK LANGUE
		$libLangSelect = substr($numAngl, 0, 4);
		$parmnumAngl = $libLangSelect . '%';
	
		$requete = "SELECT MAX(numAngl) AS numAngl FROM ANGLE WHERE numAngl LIKE '$parmnumAngl';";
		$result = $db->query($requete);
	
		if ($result) {
			$tuple = $result->fetch();
			$numAngl = $tuple["numAngl"];
			if (is_null($numAngl)) {    // New lang dans ANGLE
				// Récup dernière PK utilisée
				$requete = "SELECT MAX(numAngl) AS numAngl FROM ANGLE;";
				$result = $db->query($requete);
				$tuple = $result->fetch();
				$numAngl = $tuple["numAngl"];
	
				$numAnglSelect = (int)substr($numAngl, 4, 2);
				// No séquence suivant LANGUE
				$numSeq1Angl = $numAnglSelect + 1;
				// Init no séquence ANGLE pour nouvelle lang
				$numSeq2Angl = 1;
			} else {
				// Récup dernière PK pour FK sélectionnée
				$requete = "SELECT MAX(numAngl) AS numAngl FROM ANGLE WHERE numAngl LIKE '$parmnumAngl' ;";
				$result = $db->query($requete);
				$tuple = $result->fetch();
				$numAngl = $tuple["numAngl"];
	
				// No séquence actuel LANGUE
				$numSeq1Angl = (int)substr($numAngl, 4, 2);
				// No séquence actuel LANGUE
				$numSeq2Angl = (int)substr($numAngl, 6, 2);
				// No séquence suivant ANGLE
				$numSeq2Angl++;
			}
	
			$libAnglSelect = "ANGL";
			// PK reconstituée : ANGL + no seq langue
			if ($numSeq1Angl < 10) {
				$numAngl = $libAnglSelect . "0" . $numSeq1Angl;
			} else {
				$numAngl = $libAnglSelect . $numSeq1Angl;
			}
			// PK reconstituée : ANGL + no seq langue + no seq angle
			if ($numSeq2Angl < 10) {
				$numAngl = $numAngl . "0" . $numSeq2Angl;
			} else {
				$numAngl = $numAngl . $numSeq2Angl;
			}
		}   // End of if ($result) / no seq angle
		return $numAngl;
	} // End of function

	function create(string $numAngl, string $libAngl, string $numLang){
		global $db;

		try {
			$db->beginTransaction();

			$query = 'INSERT INTO ANGLE (numAngl, libAngl, numLang) VALUES (?, ?, ?);';
			$request = $db->prepare($query);
			$request->execute( [$numAngl, $libAngl, $numLang]);
			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert ANGLE : ' . $e->getMessage());
		}
	}

	function update(string $numAngl, string $libAngl, string $numLang){
		global $db;

		try {
			$db->beginTransaction();
			$query = 'UPDATE ANGLE SET libAngl=?,numLang=? WHERE numAngl=?;';
			$request = $db->prepare($query);
			$request->execute([$libAngl, $numLang, $numAngl]);
			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur update ANGLE : ' . $e->getMessage());
		}
	}

	// Ctrl FK sur THEMATIQUE, ANGLE, MOTCLE avec del
	function delete(string $numAngl){
		global $db;
		
		try {
			$db->beginTransaction();

			$query = 'DELETE FROM ANGLE WHERE `numAngl` = ?;';
			$request = $db->prepare($query);
			$request->execute([$numAngl]);
			$count = $request->rowCount();
			$db->commit();
			$request->closeCursor();
			return($count);
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur delete ANGLE : ' . $e->getMessage());
		}
	}
}		// End of class
