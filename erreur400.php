<?php
require_once __DIR__ . '/util/index.php';

$pageTitle = "Erreur 404";
require_once __DIR__ . '/layouts/front/head.php';
?>

    <div class=" container error-body">
        <div class="section-paragraph">
            <h1>Accès interdit</h1>
            <p>Vous n'avez pas l'autorisation de vous connecter au panel admin</p>
            <p>Seul les user de niveau superviseur ou plus y sont autorisés</p>
        </div>
    </div>

<?php require_once __DIR__ . '/layouts/front/foot.php';?>