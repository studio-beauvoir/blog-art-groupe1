<?php

require_once __DIR__ . '/../../util/index.php';
require_once __DIR__ . '/../../class_crud/motclearticle.class.php'; 

$monMotcleArticle = new motclearticle();

$result = false;
$errors = false;

$validator = Validator::make([
    ValidationRule::required('numArt')
])->bindValues($_GET);

header('Content-type:application/json;charset=utf-8');
if($validator->success()) {
    $numArt = $validator->verifiedField('numArt');
    
    $motscles = $monMotcleArticle->get_AllMotClesByNumArt($numArt);
    $result = [
        'motscles' => $motscles
    ];
} else {
    $errors = $validator->errors();
}
    
    
echo json_encode([
    'result' => $result,
    'errors' => $errors,
]);
?>