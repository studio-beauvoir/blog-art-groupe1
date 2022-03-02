<?php

require_once __DIR__ . '/../../util/index.php';
require_once __DIR__ . '/../../class_crud/angle.class.php'; 
require_once __DIR__ . '/../../class_crud/thematique.class.php'; 

$monAngle = new ANGLE();
$maThematique = new THEMATIQUE();

$result = false;
$errors = false;

$validator = Validator::make([
    ValidationRule::required('numLang')
])->bindValues($_GET);

header('Content-type:application/json;charset=utf-8');
if($validator->success()) {
    $numLang = $validator->verifiedField('numLang');
    
    $angles = $monAngle->get_AllAnglesByLang($numLang);
    $thematiques = $maThematique->get_AllThematiquesByLang($numLang);

    $result = [
        'angles' => $angles,
        'thematiques' => $thematiques,
    ];
} else {
    $errors = $validator->errors();
}
    
    
echo json_encode([
    'result' => $result,
    'errors' => $errors,
]);
?>