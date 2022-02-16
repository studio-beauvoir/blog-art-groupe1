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

		$query = 'SELECT * FROM MEMBRE;';
		$request = $db->query($query);
		$allMembres = $request->fetchAll();
		return($allMembres);
	}

	function get_ExistPseudo($pseudoMemb) {
		global $db;

		// select
		// prepare
		// execute
		return($result->rowCount());
	}

	function get_AllMembersByStat(){
		global $db;

		// select
		// prepare
		// execute
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

			// insert
			// prepare
			// execute
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

		try {
			$db->beginTransaction();
			
			// update
			// prepare
			// execute
				$db->commit();
				$request2->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			if ($passMemb == -1) {
				$request1->closeCursor();
			} else {
				$request2->closeCursor();
			}
			die('Erreur update MEMBRE : ' . $e->getMessage());
		}
	}

	// Ctrl FK sur COMMENT avec del
	function delete($numMemb){
		global $db;
		
		try {
			$db->beginTransaction();

			// delete
			// prepare
			// execute
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
}	// End of class
