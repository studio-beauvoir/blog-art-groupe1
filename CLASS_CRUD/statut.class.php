<?php
// CRUD statut
// ETUD
require_once __DIR__ . '../../connect/database.php';

class statut{
	function get_1Statut($idStat){
		global $db;

		try {
			$query = 'SELECT * FROM statut WHERE idStat=?;';
			$request = $db->prepare($query);
			
			$request->execute([$idStat]);

			$result = $request->fetch();

			if(isset($request)) {
				return($result);
			} else {
				throw new ErrorException('Statut not found');
			}
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert statut : ' . $e->getMessage());
		}
	}

	function get_AllStatuts(){
		global $db;

		// tt récupérer
		$query = 'SELECT * FROM statut;';
		$result = $db->query($query);
		$allStatuts = $result->fetchAll();

		return($allStatuts);
	}
	function get_AllStatutsExceptSuperAdmin(){
		global $db;

		// tt récupérer
		$query = 'SELECT * FROM statut WHERE idStat != 1;';
		$result = $db->query($query);
		$allStatuts = $result->fetchAll();

		return($allStatuts);
	}

	function create($libStat){
		global $db;

		try {
			$db->beginTransaction();

			// insert
			$query = 'INSERT INTO statut (libStat) VALUES (?);';
			
			// prepare
			$request = $db->prepare($query);
			
			// execute
			$request->execute( [$libStat]);

			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert statut : ' . $e->getMessage());
		}
	}

	function update($idStat, $libStat){
		global $db;

		try {
			$db->beginTransaction();

			// insert
			$query = 'UPDATE statut SET libStat=? WHERE idStat=?;';

			// prepare
			$request = $db->prepare($query);
			
			// execute
			$request->execute( [$libStat, $idStat]);
			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur update statut : ' . $e->getMessage());
		}
	}

	function delete($idStat){
		global $db;
		
		try {
			$db->beginTransaction();

			// delete
			$query = 'DELETE FROM statut WHERE `idStat` = ?;';
			// prepare
			$request = $db->prepare($query); //Va regarder où il y a des "?"
			// execute
			$request->execute( [$idStat]);
			$count = $request->rowCount(); //
			$db->commit();
			$request->closeCursor();
			return($count); //
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur delete statut : ' . $e->getMessage());
		}
	}
}	// End of class
