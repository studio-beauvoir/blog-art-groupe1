<?php
////////////////////////////////////////////////////////////
//
//  CRUD STATUT (PDO) - Modifié : 4 Juillet 2021
//
//  Script  : statut.php  -  (ETUD)  BLOGART22
//
////////////////////////////////////////////////////////////

// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';


// Insertion classe Statut
    // rajouté
    require_once __DIR__ . '/../../CLASS_CRUD/statut.class.php'; 

// Instanciation de la classe Statut
    // rajouté
    $monStatut = new STATUT(); 


// Gestion des CIR => affichage erreur sinon
$errCIR = 0;

$pageTitle = "Gestion du Statut";
include __DIR__ . '/../../layouts/back/head.php';
?>

	<h1>BLOGART22 Admin - CRUD Statut</h1>

	<hr />
	<h2>Nouveau statut :&nbsp;<a href="./createStatut.php"><i>Créer un statut</i></a></h2>
	<hr />
	<h2>Tous les statuts</h2>

	<table border="3" bgcolor="aliceblue">
    <thead>
        <tr>
            <th>&nbsp;Numéro&nbsp;</th>
            <th>&nbsp;Nom&nbsp;</th>
            <th colspan="2">&nbsp;Action&nbsp;</th>
        </tr>
    </thead>
    <tbody>
<?php
    // Appel méthode : Get tous les statuts en BDD
    $all = $monStatut->get_AllStatuts();

    // Boucle pour afficher
    foreach($all as $row) {
        // la boucle va écrire le code html juste en dessous
        // on ferme la boucle quelques lignes plus tard
?>
        <tr>
		<td><h4>&nbsp; <?= $row['idStat']; ?> &nbsp;</h4></td>

        <td>&nbsp; <?= $row['libStat']; ?> &nbsp;</td>

<?php
        if ($row['idStat'] != 1) {  // superAdmin
?>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="./updateStatut.php?id=<?=$row['idStat']; ?>"><i><img src="./../../img/valider-png.png" width="20" height="20" alt="Modifier statut" title="Modifier statut" /></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
		<br /></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="./deleteStatut.php?id=<?=$row['idStat']; ?>"><i><img src="./../../img/supprimer-png.png" width="20" height="20" alt="Supprimer statut" title="Supprimer statut" /></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
		<br /></td>
<?php
        } else {
?>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="./updateStatut.php?id=<?=$row['idStat']; ?>"><i><img src="./../../img/valider-png.png" width="20" height="20" alt="Modifier statut" title="Modifier statut" /></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
		<br /></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="superAdmin"><i><img src="./../../img/supprimer-png.png" width="20" height="20" alt="Supprimer statut" title="Supprimer statut" /></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
		<br /></td>
<?php
        }   // End of else if
?>
        </tr>
<?php
    // c'est ici qu'on ferme la boucle
	}	// End of foreach
?>
    </tbody>
    </table>
<?php
    // Si erreur sur retour del => aff msg "CIR KO"
    if ($errCIR == 1) {
?>
        <i><div class="error"><br>=>&nbsp;Suppression impossible, existence de user(s) associé(s) à ce statut. Vous devez d'abord supprimer le(s) user(s) concerné(s).</div></i>
<?php
    }   // End of if ($errCIR == 1)
?>
    <p>&nbsp;</p>
<?php
require_once __DIR__ . '/footer.php';
?>
</body>
</html>
