<?php

require_once __DIR__ . '/../../util/index.php';
require_once __DIR__ . '/../../class_crud/motclearticle.class.php'; 

$monMotcleArticle = new MOTCLEARTICLE();

$result = false;
$errors = false;

$validator = Validator::make([
    ValidationRule::required('libTitrArt')
])->bindValues($_GET);

header('Content-type:application/json;charset=utf-8');
if($validator->success()) {
    $libTitrArt = $validator->verifiedField('libTitrArt');
    
    $motcles = $monMotcleArticle->get_AllMotClesByLibTitrArt($libTitrArt);
    $result = [
        'motcles' => $motcles
    ];
} else {
    $errors = $validator->errors();
}
    
    
echo json_encode([
    'result' => $result,
    'errors' => $errors,
]);
?>