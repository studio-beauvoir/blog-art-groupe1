<?php

require_once __DIR__ . '/../../util/index.php';
require_once __DIR__ . '/../../connect/database.php';


$result = false;
$errors = false;



$validator = Validator::make([
    ValidationRule::required('motscles')
])->bindValues($_GET);

header('Content-type:application/json;charset=utf-8');
if($validator->success()) {
    $motscles = $validator->verifiedField('motscles');
    global $db;
    $query = 'SELECT motcle.*, motclearticle.*, article.numArt,article.libTitrArt, article.libChapoArt, article.urlPhotArt FROM motcle 
    JOIN motclearticle ON motcle.numMotCle = motclearticle.numMotCle
    JOIN article ON motclearticle.numArt = article.numArt
    WHERE motcle.libMotCle = ? ';
    $request = $db->prepare($query);
    $request->execute([$motscles]);
    $articles = $request->fetchAll();

    $result = [
        'articles' => $articles,
    ];
} else {
    $errors = $validator->errors();
}

    
echo json_encode([
    'result' => $result,
    'errors' => $errors,
]);
?>