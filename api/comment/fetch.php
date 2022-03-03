<?php

require_once __DIR__ . '/../../util/index.php';
require_once __DIR__ . '/../../class_crud/comment.class.php'; 

$monComment = new comment(); 

$result = false;
$errors = false;

$validator = Validator::make([
    ValidationRule::required('numArt')
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