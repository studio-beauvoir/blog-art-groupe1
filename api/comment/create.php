<?php

require_once __DIR__ . '/../../middleware/getMember.php';
require_once __DIR__ . '/../../util/index.php';
require_once __DIR__ . '/../../class_crud/comment.class.php'; 

$monComment = new comment(); 

$result = false;
$errors = false;
$code = 0;

$validator = Validator::make([
    ValidationRule::required('numArt'),
    ValidationRule::required('libCom'),
])->bindValues($_POST);

header('Content-type:application/json;charset=utf-8');
if($validator->success()) {
    if($loggedMember) {

        $libCom = $validator->verifiedField('libCom');
        // $numMemb = $validator->verifiedField('numMemb'); 
        $numMemb = $loggedMember['numMemb'];
        $numArt = $validator->verifiedField('numArt');
        $numSeqCom = $monComment->getNextNumCom($numArt);
        

        $monComment->create($numSeqCom, $numArt, $libCom, $numMemb);

        $result = [];
    } else {
        $errors = ['Vous devez être connecté'];
        $code = 1;
    }
} else {
    $errors = $validator->errors();
}
    
    
echo json_encode([
    'code' => $code,
    'result' => $result,
    'errors' => $errors,
]);
?>