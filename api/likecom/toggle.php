<?php

require_once __DIR__ . '/../../middleware/logged.php';
require_once __DIR__ . '/../../util/index.php';
require_once __DIR__ . '/../../CLASS_CRUD/LIKECOM.class.php'; 

$monLikeCom = new LIKECOM(); 

$result = false;
$errors = false;

$validator = Validator::make([
    ValidationRule::required('numArt'),
    ValidationRule::required('numSeqCom'),
])->bindValues($_POST);

header('Content-type:application/json;charset=utf-8');
if($validator->success()) {
    $numArt = $validator->verifiedField('numArt');
    $numSeqCom = $validator->verifiedField('numSeqCom');
    $numMemb = $loggedMember['numMemb'];
    

    $monLikeCom->createOrtoggle($numMemb, $numSeqCom, $numArt);

    $result = [];
} else {
    $errors = $validator->errors();
}
    
    
echo json_encode([
    'result' => $result,
    'errors' => $errors,
]);
?>