<?php

$submitBtn = "Créer";
$pageCrud = "langue";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "$submitBtn: $pageCrud";
$pageNav = ['Home:/index1.php', 'Gestion des '.$pageCrud.'s:'.$pagePrecedent, $pageTitle];

require_once __DIR__ . '/util/index.php';

$pageTitle = "Panel user";
$pageNav = ['Connexion'];
require_once __DIR__ . '/layouts/front/head.php';
?>

<form method="POST" action="index1.php">
    <label>Pseudo</label>
	<input type="text" name="username">
    <label> Mot de passe </label>
	<input type="password" name="password"> <br/><br/>
    <input class="btn btn-lg" title="Se connecter" type="submit" value="Connexion" />
</form>

<?php require_once __DIR__ . '/layouts/front/foot.php';?>