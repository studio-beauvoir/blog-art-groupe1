<?php
// CRUD user
// ETUD
require_once __DIR__ . '../../connect/database.php';

class user{
	function get_1User($pseudoUser){
		global $db;
		$db->beginTransaction();
		try {
			$query = 'SELECT * FROM user INNER JOIN statut ON user.idStat=statut.idStat WHERE pseudoUser=?;';
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
			die('Erreur insert user : ' . $e->getMessage());
		}
	}

	function get_AllUsers(){
		global $db;

		$db->beginTransaction();
		$query = 'SELECT * FROM user INNER JOIN statut ON user.idStat=statut.idStat;';
		$request = $db->query($query);
		$allUsers = $request->fetchAll();

		$db->commit();
		$request->closeCursor();
		return($allUsers);
	}

	// Inutile car la PK (pseudo, pass) est forcément unique
	function get_ExistPseudo($pseudoUser) {
		global $db;

		$query = 'SELECT * FROM user WHERE pseudoUser = ?;';
		$result = $db->prepare($query);
		$result->execute(array($pseudoUser));
		return($result->rowCount());
	}

	function get_AllUsersByStat(){
		global $db;

		// select
		// prepare
		// execute
		// return($allUsersByStat);
	}

	function get_NbAllUsersByidStat($idStat){
		global $db;

		$db->beginTransaction();

		$query = 'SELECT * FROM user WHERE idStat=?;';
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

			$query = 'INSERT INTO user (pseudoUser, nomUser, prenomUser, eMailUser, passUser, idStat) VALUES (?, ?, ?, ?, ?, ?);';
			$request = $db->prepare($query);
			$request->execute([$pseudoUser, $nomUser, $prenomUser, $eMailUser, $passUser, $idStat]);
			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert user : ' . $e->getMessage());
		}
	}

	function update($pseudoUser, $nomUser, $prenomUser, $eMailUser, $passUser, $idStat){
		global $db;

		try {
			$db->beginTransaction();
				
			$query = 'UPDATE user SET nomUser=?, prenomUser=?, eMailUser=?, passUser=?, idStat=? WHERE pseudoUser=?;';
			$request = $db->prepare($query);
			$request->execute([$nomUser, $prenomUser, $eMailUser, $passUser, $idStat, $pseudoUser]);
			$db->commit();
			$request->closeCursor();

			//De Queutin mais thanks to Arthaud, merci Arthaud
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur update user : ' . $e->getMessage());
		}
	}

	function delete($pseudoUser){
		global $db;
		
		try {
			$db->beginTransaction();

			$query = 'DELETE FROM user WHERE `pseudoUser` = ?;';
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
			die('Erreur delete user : ' . $e->getMessage());
		}
	}


	function login($pseudoUser, $passUser) {
		global $db;

		// // requête pour savoir si l'id et le mdp son bon
		// $db->beginTransaction();
		// $query = "SELECT * FROM membre WHERE pseudoUser = ? AND passUser = ?";
		// $request = $db->prepare($query);
		// $request->execute([$pseudoUser, $passUser]);
		// $rowCount = $request->rowCount();


		// on commence par chercher le user
		$db->beginTransaction();
		$query = "SELECT * FROM user WHERE pseudoUser = ?";
		$request = $db->prepare($query);
		$request->execute([$pseudoUser]);
		$rowCount = $request->rowCount();


		if($rowCount < 1){
			// pas de correspondance dan la bdd

			$db->commit();
			$request->closeCursor();

			return [
				"error"=>true,
				"message"=>"Ce pseudo n'est lié à aucun compte"
			];
		}else{
			$user = $request->fetch();

			$db->commit();
			$request->closeCursor();

			// ensuite on check que les mdp soient bon
			if (password_verify($passUser, $user['passUser']))
			{

				session_start();
				$_SESSION['member_id'] = $user['numUser'];
				// setcookie('session_token', customEncrypt('true.'.$user['numUser'].'.'.$user['passUser'].$user['dtCreaUser']));
				header('location: '.webSitePath('/profil.php'));			
				return [
					"error"=>false
				];
			}
			
			return [
				"error"=>true,
				"message"=>"Le mot de passe est incorrect"
			];
		}
	}
}	// End of class
