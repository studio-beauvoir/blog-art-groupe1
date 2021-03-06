<?php

require_once __DIR__ . '/../../middleware/getMember.php';
require_once __DIR__ . '/../../util/index.php';
require_once __DIR__ . '/../../class_crud/likeart.class.php'; 

$monLikeArt = new likeart(); 

$result = false;
$errors = false;
$code = 0;

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
        $code = 1;
    }
} else {
    $errors = $validator->errors();
}
    
echo json_encode([
    'result' => $result,
    'code' => $code,
    'errors' => $errors,
]);
?>