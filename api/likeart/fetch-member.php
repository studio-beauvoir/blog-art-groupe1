<?php

require_once __DIR__ . '/../../middleware/logged.php';
require_once __DIR__ . '/../../util/index.php';
require_once __DIR__ . '/../../class_crud/LIKEART.class.php'; 

$monLikeArt = new LIKEART(); 

$result = false;
$errors = false;

header('Content-type:application/json;charset=utf-8');
if($loggedMember) {
    $numMemb = $loggedMember['numMemb'];
    
    $result = [
        'likes' => $monLikeArt->get_AllLikesArtByNumMemb($numMemb)
    ];
} else {
    $errors = ['Vous devez être connecté'];
}
    
    
echo json_encode([
    'result' => $result,
    'errors' => $errors,
]);
?>

