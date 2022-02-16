<?php
require_once __DIR__ . '/../../util/index.php';

// Insertion classe MotCle
require_once __DIR__ . '/../../CLASS_CRUD/motcle.class.php';

//Instanciation de la classe MOTCLE
$monMotCle = new MOTCLE();

$pageTitle = "Gestion des Mots Clés";
$pageNav = ['Home:/index1.php', $pageTitle];
include __DIR__ . '/../../layouts/back/head.php';

?>



<!DOCTYPE html>
<html lang="fr-FR">
<head>
	<title>Admin - CRUD Mot Clé</title>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="author" content="" />
</head>
<body>
    <h1>BLOGART22 Admin - CRUD Mot Clé</h1>

	<hr />
	<h2>Nouveau Mot Clé :&nbsp;<a href="./createMotCle.php"><i>Créer un Mot Clé</i></a></h2>
	<hr />
	<h2>Tous les Mots Clés</h2>

	<table border="3" bgcolor="aliceblue">
    <thead>
        <tr>
            <th>&nbsp;Numéro&nbsp;</th>
            <th>&nbsp;Nom Mot Clé&nbsp;</th>
            <th>&nbsp;Langue&nbsp;</th>
            <th colspan="2">&nbsp;Action&nbsp;</th>
        </tr>
    </thead>
    <tbody>

<?php
    // Appel méthode : Get toutes les mots cles en BDD

    // Boucle pour afficher
    //foreach($all as $row) {
?>
        <tr>

		<td><h4>&nbsp; <?= "ici numMotCle"; ?> &nbsp;</h4></td>

        <td>&nbsp; <?= "ici libMotCle"; ?> &nbsp;</td>

        <td>&nbsp; <?= "ici lib1Lang"; ?> &nbsp;</td>

		<td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="./updateMotCle.php?id=<?=1; ?>"><i><img src="./../../img/valider-png.png" width="20" height="20" alt="Modifier mot clé" title="Modifier mot clé" /></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
		<br /></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="./deleteMotCle.php?id=<?=1; ?>"><i><img src="./../../img/supprimer-png.png" width="20" height="20" alt="Supprimer mot clé" title="Supprimer mot clé" /></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
		<br /></td>

        </tr>
<?php
	// }	// End of foreach
?>
    </tbody>
    </table>
    <br /><br/>
<?php
require_once __DIR__ . '/footer.php';
?>
</body>
</html>



//Ajout avec archi Arthaud

<a class="btn btn-lg" href="./createMotCle.php" title="Créer une Langue">Créer une Langue</a>
	<h3>Tous les mots clés</h3>

	<table >
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Nom</th>
                <th>Langue</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Appel méthode : Get tous les statuts en BDD
        $all = $monMotCle->get_AllMotCles();
        // Boucle pour afficher
        foreach($all as $row) {
            // la boucle va écrire le code html juste en dessous
            // on ferme la boucle quelques lignes plus tard
        ?>
            <tr>
                <td><h4> <?= $row['numMotCle']; ?> </h4></td>
                <td><?= $row['libMotCle']; ?></td>
                <td><?= $row['lib1Lang']; ?></td>
                
                <!-- actions -->
                <td>
                    <a class="btn btn-md" href="./updateMotCle.php?id=<?=$row['numMotCle']; ?>" title="Modifier le mot clé">Modifier</a>
                </td>
                <td>  
                    <!-- lien : test ternaire super admin -->
                    <a class="btn btn-md btn-danger" href="<?= $row['idStat']!=1?'./deleteMotCle.php?id='.$row['numMotCle']:'#'; ?>" title="Supprimer le mot clé">Supprimer</a>
                </td>
            </tr>
        <?php }	// End of foreach ?>
        </tbody>
    </table>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>