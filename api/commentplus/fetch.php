<?php

require_once __DIR__ . '/../../util/index.php';
require_once __DIR__ . '/../../class_crud/commentplus.class.php'; 

$monComment = new commentplus(); 

$result = false;
$errors = false;

$validator = Validator::make([
    ValidationRule::required('numArt')
])->bindValues($_GET);

header('Content-type:application/json;charset=utf-8');
if($validator->success()) {
    $numArt = $validator->verifiedField('numArt');
    
    $commentsplus = $monComment->get_AllCommentPlusByArticle($numArt);

    $result = [
        'commentsplus' => $commentsplus
    ];
} else {
    $errors = $validator->errors();
}
    
    
echo json_encode([
    'result' => $result,
    'errors' => $errors,
]);
?>