<?php

$submitBtn = "CRUD";
$pageCrud = "commentaire";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "$submitBtn - $pageCrud";
$pageNav = ['Home:/admin.php', $pageTitle];

require_once __DIR__ . '/../../util/index.php';
require_once __DIR__ . '/../../class_crud/comment.class.php'; 

$monComment = new COMMENT(); 

require_once __DIR__ . '/../../layouts/back/head.php';
?>
	<a class="btn btn-lg" href="./createComment.php" title="Créer un commentaire">Créer un commentaire</a>
	<h3>Tous les commentaires</h3>

	<table>
        <thead>
            <tr>
                <th>Numéro<br>Article</th>
                <th>Numéro<br>Comment</th>
                <th>Pseudo</th>
                <th>Date création<br>Commentaire</th>
                <th>Commentaire</th>
                <th>Date modération</th>
                <th>Commentaire<br>visible</th>
                <th>Justification modération<br>si non visible</th>
                <th>Delete<br>logique</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        
        <tbody>
            <?php
                $from = 'Y-m-d H:i:s';
                $to = 'd/m/Y H:i:s';

                $all = $monComment->get_AllComments();
                foreach($all as $row) {
            ?>
            <tr>
                <td><h4> <?= $row['numArt']; ?> </h4></td>
                <td> <?= $row['numSeqCom']; ?> </td>
                <td> <?= $row['pseudoMemb']; ?> </td>
                <td> <?= dateChangeFormat($row['dtCreCom'],$from,$to); ?> </td>
                <td> <?= $row['libCom']; ?> </td>
                <td> <?= dateChangeFormat($row['dtModCom'],$from,$to); ?> </td> 
                <td> <?= $row['attModOK']; ?> </td> 
                <td> <?= $row['notifComKOAff']; ?> </td> 
                <td> <?= $row['delLogiq']; ?> </td> 
                <td>
                    <a class="btn btn-md" href="./updateComment.php?idCom=<?=$row['numSeqCom'];?>&idArt=<?=$row['numArt']?>" title="Modifier l'article">Modifier</a>
                </td>
                <td>
                    <a class="btn btn-md btn-danger" href="./deleteComment.php?idCom=<?=$row['numSeqCom'];?>&idArt=<?=$row['numArt']?>" title="Supprimer l'article">Supprimer</a>
                </td>
            </tr>
            <?php }	?>
        </tbody>
    </table>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>