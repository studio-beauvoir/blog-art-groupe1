<?php
require_once __DIR__ . '/util/index.php';



$pageTitle = "Panel user";
$pageNav = ['Inscription'];
require_once __DIR__ . '/layouts/front/head.php';
?>





<?php require_once __DIR__ . '/layouts/front/foot.php';?>


<!-- Connection : Vérifier si l'utilisateur est 
déjà connecté ou pas avec les cookies, sinon lui 
dire de le faire. 

MDP : Hasher le mot de passe 
(créer une nouvelle chaine de caractère unique)
    echo(password_hash($pass, PASSWORD_DEFAULT>));
        --Affiche le mot de passe en "hash", il est "crypté
w
    if($_SERVER['REQUEST_METHOD']=='POST') {
        echo($_POST['pass'])
        if(password_verify($_POST['pass'], $pass) === true) {
            --Permet de vérifier le mot de passe, 
                si c'est 1, cest OK
            echo('<p>Bon mot de passe </p>');
            setcookie('user', $user, time() + 3600);
        } else {
            echo('<p>Mauvais mot de passe </p>')
        }
    }

    if(isset($_COOKIE['user'])){
        echo 'Bonjour' . $_COOKIE['user'] 
    }
    else {
        echo "Merci de vous connecter" 
    }