<?php

require_once __DIR__ . '/../../middleware/getMember.php';
require_once __DIR__ . '/../../util/index.php';
require_once __DIR__ . '/../../class_crud/comment.class.php'; 
require_once __DIR__ . '/../../class_crud/commentplus.class.php'; 

$monComment = new comment(); 
$monCommentPlus = new commentplus(); 

$result = false;
$errors = false;
$code = 0;

$validator = Validator::make([
    ValidationRule::required('numSeqComR'),
    ValidationRule::required('numArtR'),
    ValidationRule::required('numArt'),
    ValidationRule::required('libCom'),
])->bindValues($_POST);

header('Content-type:application/json;charset=utf-8');
if($validator->success()) {
    if($loggedMember) {
        $numSeqComR = $validator->verifiedField('numSeqComR');
        $numArtR = $validator->verifiedField('numArtR');

        $libCom = $validator->verifiedField('libCom');
        
        $numArt = $validator->verifiedField('numArt');
        $numSeqCom = $monComment->getNextNumCom($numArt);
        
        $numMemb = $loggedMember['numMemb'];

        $commentPlus = $monComment->get_1Comment($numSeqComR, $numArtR);

        $pseudoMembAnswered = $commentPlus['pseudoMemb'];

        $libCom = "@$pseudoMembAnswered: $libCom";

        $monComment->create($numSeqCom, $numArt, $libCom, $numMemb);

        $monCommentPlus->create($numSeqCom, $numArt, $numSeqComR, $numArtR);

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