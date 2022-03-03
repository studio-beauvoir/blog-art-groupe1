<?php

require_once __DIR__ . '/../../middleware/loggedMember';
require_once __DIR__ . '/../../util/index.php';
require_once __DIR__ . '/../../class_crud/LIKEART.class.php'; 

$monLikeArt = new LIKEART(); 

$result = false;
$errors = false;

$validator = Validator::make([
    ValidationRule::required('numArt')
])->bindValues($_POST);

header('Content-type:application/json;charset=utf-8');
if($validator->success()) {
    if($loggedMember) {
        $numArt = $validator->verifiedField('numArt');
        $numMemb = $loggedMember['numMemb'];

        $monLikeArt->createOrtoggle($numMemb, $numArt);

        $result = $monLikeArt->get_nbLikesArtByArticle($numArt)[0];
    } else {
        $errors = ['Vous devez être connecté'];
    }
} else {
    $errors = $validator->errors();
}
    
echo json_encode([
    'result' => $result,
    'errors' => $errors,
]);
?>