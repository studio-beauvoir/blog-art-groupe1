<?php

require_once __DIR__ . '/../../util/index.php';
require_once __DIR__ . '/../../CLASS_CRUD/comment.class.php'; 

$monComment = new COMMENT(); 

$result = false;
$errors = false;

$validator = Validator::make([
    ValidationRule::required('numArt'),
    ValidationRule::required('libCom'),
])->bindValues($_GET);

header('Content-type:application/json;charset=utf-8');
if($validator->success()) {
    $numArt = $validator->verifiedField('numArt');
    
    $comments = $monComment->get_AllCommentsByNumArt($numArt);

    $result = [
        'comments' => $comments
    ];
} else {
    $errors = $validator->errors();
}
    
    
echo json_encode([
    'result' => $result,
    'errors' => $errors,
]);
?>