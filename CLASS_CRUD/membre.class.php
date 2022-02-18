<?php
// CRUD MEMBRE
// ETUD
// A tester sur Blog'Art
require_once __DIR__ . '../../CONNECT/database.php';

class MEMBRE{
	function get_1Membre($numMemb){
		global $db;

		try {
			$query = 'SELECT * FROM MEMBRE WHERE numMemb=?;';
			$request = $db->prepare($query);
			
			$request->execute([$numMemb]);

			$result = $request->fetch();

			if(isset($request)) {
				return($result);
			} else {
				throw new ErrorException('Member not found');
			}
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert MEMBRE : ' . $e->getMessage());
		}
	}

	function get_1MembreByEmail($eMailMemb){
		global $db;

		$query = 'SELECT * FROM THEMATIQUE WHERE eMailMemb=?;';
		$request = $db->prepare($query);
		$request->execute([$eMailMemb]);
		$result = $request->fetch();
		return($result->fetch());
	}

	function get_AllMembres(){
		global $db;

		$query = 'SELECT * FROM MEMBRE INNER JOIN STATUT ON MEMBRE.idStat=STATUT.idStat;';
		$request = $db->query($query);
		$allMembres = $request->fetchAll();
		return($allMembres);
	}

	//A VERIFIER
	function get_ExistPseudo($pseudoMemb) {
		global $db;

		$db->beginTransaction();

		$query = 'SELECT * FROM MEMBRE WHERE idStat=?;';
		$request = $db->prepare($query);
		$request->execute([$pseudoMemb]);
		$result = $request->fetch();
		return($result->rowCount());
	}

	function get_AllMembersByStat(){
		global $db;

		$query = 'SELECT * FROM MEMBRE WHERE idStat=?;';
		$result = $db->query($query);
		$allMembersByStat = $result->fetchAll();
		return($allMembersByStat);
	}

	function get_NbAllMembersByidStat($idStat){
		global $db;

		$db->beginTransaction();

		$query = 'SELECT * FROM MEMBRE WHERE idStat=?;';
		$request = $db->prepare($query);
		
		$request->execute([$idStat]);

		// $db->commit();
		// execute
		$allMembersByStat = $request->fetchAll(); // [...,  ...]
		
		$db->commit();
		$request->closeCursor();
		
		$allNbMembersByStat = count($allMembersByStat); // 2 par exemple 
		return($allNbMembersByStat);
	}

	function get_AllMembresByEmail($eMailMemb){
		global $db;
		$query = 'SELECT * FROM ANGLE WHERE eMailMemb=?;';
		$result = $db->query($query);
		$allMembresByEmail = $result->fetchAll();
		return($allMembresByEmail);
	}

	// Inscription membre
	function create($prenomMemb, $nomMemb, $pseudoMemb, $passMemb, $eMailMemb, $dtCreaMemb, $accordMemb, $idStat){
		global $db;

		try {
			$db->beginTransaction();

			$query = 'INSERT INTO MEMBRE (prenomMemb, nomMemb, pseudoMemb, passMemb, eMailMemb, dtCreaMemb, accordMemb, idStat) VALUES (?, ?, ?, ?, ?, ?, ?, ?);';
			$request = $db->prepare($query);
			$request->execute([$prenomMemb, $nomMemb, $pseudoMemb, $passMemb, $eMailMemb, $dtCreaMemb, $accordMemb, $idStat]);
			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert MEMBRE : ' . $e->getMessage());
		}
	}

	function update($numMemb, $prenomMemb, $nomMemb, $passMemb, $eMailMemb, $idStat){
		global $db;

		var_dump($idStat);

		try {
			$db->beginTransaction();
			
			$query = 'UPDATE MEMBRE SET prenomMemb=?, nomMemb=?, passMemb=?, eMailMemb=?, idStat=? WHERE numMemb=?;';
			$request = $db->prepare($query);
			$request->execute([$prenomMemb, $nomMemb, $passMemb, $eMailMemb, $idStat, $numMemb]);
			$db->commit();
			$request->closeCursor(); //request2
		}
		catch (PDOException $e) {
			$db->rollBack();
			if ($passMemb == -1) {
				$request->closeCursor(); //request1
			} else {
				$request->closeCursor(); //request2
			}
			die('Erreur update MEMBRE : ' . $e->getMessage());
		}
	}

	// Ctrl FK sur COMMENT avec del
	function delete($numMemb){
		global $db;
		
		try {
			$db->beginTransaction();

			$query = 'DELETE FROM MEMBRE WHERE `numMemb` = ?;';
			$request = $db->prepare($query);
			$request->execute([$numMemb]);
			$count = $request->rowCount();
			$db->commit();
			$request->closeCursor();
			return($count);
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur delete MEMBRE : ' . $e->getMessage());
		}
	}


	function register($prenomMemb, $nomMemb, $pseudoMemb, $passMemb, $eMailMemb, $dtCreaMemb, $accordMemb){
		die('pas encore fait');
		$idStat = 3; // Membre niveau 1
		$this->create();
	}

	function login() {
		// $query = 'SELECT * FROM MEMBRE WHERE numMemb = ?;';
		// $result = $db->prepare($query);
		// $result->execute([$_SESSION['numMemb']]);
		// $rowU = $result->fetch();
		// if($rowU){
		//     $numMemb = $rowU['numMemb'];
		//     $your_name = $rowU['your_name'];
		// }

		
		$query = "SELECT * FROM MEMBRE WHERE pseudoMemb = ? AND passMemb = ?";
		$result = $db->prepare($query);
		$result->execute([$pseudoMemb, $passMemb]);
		$rowCount = $result->rowCount();

		if($rowCount < 1){
			$_SESSION['message'] = "Erreur de Login. Veuillez réessayer.";
			// header('location: connexion.php');
		}else{
			$row = $result->fetch();
			$_SESSION['userid'] = $row['userid'];
			header('location: index1.php');
		}
	}
}	// End of class
