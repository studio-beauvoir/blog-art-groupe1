<?php

require_once __DIR__ . '/../../util/index.php';
require_once __DIR__ . '/../../class_crud/motcle.class.php'; 

$monMotcle = new MOTCLE();

$result = false;
$errors = false;

$validator = Validator::make([
    ValidationRule::required('numLang')
])->bindValues($_GET);

header('Content-type:application/json;charset=utf-8');
if($validator->success()) {
    $numLang = $validator->verifiedField('numLang');
    
    $motscles = $monMotcle->get_AllMotsClesByLang($numLang);

    $result = [
        'motscles' => $motscles,
    ];
} else {
    $errors = $validator->errors();
}
    
    
echo json_encode([
    'result' => $result,
    'errors' => $errors,
]);
?>