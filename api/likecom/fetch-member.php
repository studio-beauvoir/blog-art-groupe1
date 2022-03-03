<?php

require_once __DIR__ . '/../../middleware/getMember.php';
require_once __DIR__ . '/../../util/index.php';
require_once __DIR__ . '/../../class_crud/likecom.class.php'; 

$monLikeCom = new likecom(); 

$result = false;
$errors = false;
$code = 0;

header('Content-type:application/json;charset=utf-8');
if($loggedMember) {
    $numMemb = $loggedMember['numMemb'];
    
    $result = [
        'likes' => $monLikeCom->get_AllLikesComByMembre($numMemb)
    ];
} else {
    $errors = ['Vous devez être connecté'];
    $code = 1;
}
    
    
echo json_encode([
    'code' => $code,
    'result' => $result,
    'errors' => $errors,
]);
?>

