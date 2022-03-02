<?php
// CRUD USER
// ETUD
require_once __DIR__ . '../../connect/database.php';

class USER{
	function get_1User($pseudoUser){
		global $db;
		$db->beginTransaction();
		try {
			$query = 'SELECT * FROM USER INNER JOIN STATUT ON USER.idStat=STATUT.idStat WHERE pseudoUser=?;';
			$request = $db->prepare($query);
			
			$request->execute([$pseudoUser]);

			$result = $request->fetch();

			$db->commit();
			$request->closeCursor();
			if(isset($request)) {
				return($result);
			} else {
				throw new ErrorException('User not found');
			}
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert USER : ' . $e->getMessage());
		}
	}

	function get_AllUsers(){
		global $db;

		$db->beginTransaction();
		$query = 'SELECT * FROM USER INNER JOIN STATUT ON USER.idStat=STATUT.idStat;';
		$request = $db->query($query);
		$allUsers = $request->fetchAll();

		$db->commit();
		$request->closeCursor();
		return($allUsers);
	}

	// Inutile car la PK (pseudo, pass) est forcément unique
	function get_ExistPseudo($pseudoUser) {
		global $db;

		$query = 'SELECT * FROM USER WHERE pseudoUser = ?;';
		$result = $db->prepare($query);
		$result->execute(array($pseudoUser));
		return($result->rowCount());
	}

	function get_AllUsersByStat(){
		global $db;

		// select
		// prepare
		// execute
		return($allUsersByStat);
	}

	function get_NbAllUsersByidStat($idStat){
		global $db;

		$db->beginTransaction();

		$query = 'SELECT * FROM USER WHERE idStat=?;';
		$request = $db->prepare($query);
		
		$request->execute([$idStat]);

		// execute
		$allUsersByStat = $request->fetchAll(); // [...,  ...]

		$db->commit();
		$request->closeCursor();

		$allNbUsersByStat = count($allUsersByStat); // 2 par exemple 
		return($allNbUsersByStat);
	}

	function create($pseudoUser, $nomUser, $prenomUser, $eMailUser, $passUser, $idStat){
		global $db;

		try {
			$db->beginTransaction();

			$query = 'INSERT INTO USER (pseudoUser, nomUser, prenomUser, eMailUser, passUser, idStat) VALUES (?, ?, ?, ?, ?, ?);';
			$request = $db->prepare($query);
			$request->execute([$pseudoUser, $nomUser, $prenomUser, $eMailUser, $passUser, $idStat]);
			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert USER : ' . $e->getMessage());
		}
	}

	function update($pseudoUser, $nomUser, $prenomUser, $eMailUser, $passUser, $idStat){
		global $db;

		try {
			$db->beginTransaction();
				
			$query = 'UPDATE USER SET nomUser=?, prenomUser=?, eMailUser=?, passUser=?, idStat=? WHERE pseudoUser=?;';
			$request = $db->prepare($query);
			$request->execute([$nomUser, $prenomUser, $eMailUser, $passUser, $idStat, $pseudoUser]);
			$db->commit();
			$request->closeCursor();

			//De Queutin mais thanks to Arthaud, merci Arthaud
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur update USER : ' . $e->getMessage());
		}
	}

	function delete($pseudoUser){
		global $db;
		
		try {
			$db->beginTransaction();

			$query = 'DELETE FROM USER WHERE `pseudoUser` = ?;';
			$request = $db->prepare($query);
			$request->execute([$pseudoUser]);
			$count = $request->rowCount();
			$db->commit();
			$request->closeCursor();
			return($count);
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur delete USER : ' . $e->getMessage());
		}
	}
}	// End of class
