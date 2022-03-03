<?php
// Plusieurs tags

// Insertion fichiers utiles
require_once __DIR__ . '/../util/index.php';

// Insertion classe Article
require_once __DIR__ . '/../class_crud/article.class.php';

// Instanciation Classe Article
$monArticle = new ARTICLE(); 

// Initialisation var


// Recherche / Affichage articles




?>
<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <title>Barre de recherche</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link href="./../back/css/style4.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .error {
            padding: 2px;
            border: solid 0px black;
            color: red;
            font-style: italic;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>BLOGART22 Admin - Barre de recherche des Articles</h1>
    <h2>Un seul mot clé parmi les articles (F2 en GET)</h2>
    <br /><hr /><br />
    <form method="GET">
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="search" name="search" size="40" placeholder="Recherche par mot clé..." />
    </form>
    <br /><hr /><br />

    <br><br>
<?php
require_once __DIR__ . '/footer.php';
?>
</body>
</html>
