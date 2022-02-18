<?php

$submitBtn = "Créer";
$pageCrud = "langue";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "$submitBtn: $pageCrud";
$pageNav = ['Home:/index1.php', 'Gestion des '.$pageCrud.'s:'.$pagePrecedent, $pageTitle];

require_once __DIR__ . '/util/index.php';
require_once __DIR__ . '/CONNECT/database.php';
require_once __DIR__ . '/layouts/front/head.php';

$pageTitle = "Panel user";
$pageNav = ['Connexion'];

global $db;


// $query = 'SELECT * FROM MEMBRE WHERE numMemb = ?;';
// $result = $db->prepare($query);
// $result->execute([$_SESSION['numMemb']]);
// $rowU = $result->fetch();
// if($rowU){
//     $numMemb = $rowU['numMemb'];
//     $your_name = $rowU['your_name'];
// }



$pseudoMemb = ctrlSaisies($_POST['pseudoMemb']);
$passMemb = ctrlSaisies($_POST['passMemb']);

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
?>


<h1>Connexion</h1>
<form method="POST" action="index1.php">

    <div class="field">
        <label>Pseudo</label>
        <input type="text" name="pseudoMemb">
    </div>
    
    <div class="field">
        <label> Mot de passe </label>
        <input type="passMemb" name="passMemb"> <br/><br/>
    </div>

    <input class="btn btn-lg" title="Se connecter" type="submit" value="Connexion" />

</form>

<?php require_once __DIR__ . '/layouts/front/foot.php';?>