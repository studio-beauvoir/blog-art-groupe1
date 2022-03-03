<?php

require_once __DIR__ . '/../../middleware/loggedMember.php';
require_once __DIR__ . '/../../util/index.php';
require_once __DIR__ . '/../../class_crud/likecom.class.php'; 
require_once __DIR__ . '/../../class_crud/comment.class.php'; 

$monLikeCom = new likecom(); 
$monComment = new comment(); 

$result = false;
$errors = false;

$validator = Validator::make([
    ValidationRule::required('numArt'),
    ValidationRule::required('numSeqCom'),
])->bindValues($_POST);

header('Content-type:application/json;charset=utf-8');
if($validator->success()) {
    if($loggedMember) {
        $numArt = $validator->verifiedField('numArt');
        $numSeqCom = $validator->verifiedField('numSeqCom');
        $numMemb = $loggedMember['numMemb'];
        

        $monLikeCom->createOrtoggle($numMemb, $numSeqCom, $numArt);

        $result = [
            'comment' => $monComment->get_1Comment($numSeqCom, $numArt)
        ];
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