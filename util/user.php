<?php

require_once __DIR__ . '/../class_crud/user.class.php';

function getLoggedUserOrFalse() {
    $monUser = new user();
    $loggedUser = false;

    // if(isset($_COOKIE['session_token'])) {
    //     // membre potentiellement loggé
    //     $potentialToken = customDecrypt($_COOKIE['session_token']);
    //     $data = explode('.', $potentialToken);
    
    //     if(count($data) > 2 AND $data[0] === "true") { // le token est valide
    //         $numMemb = intval($data[1]);
    
    //         $potentialUser = $monUser->get_1User($numMemb);
    //         if($potentialUser) {
    //             // membre connecté
    //             $loggedUser = $potentialUser;
    //         }
    //     }
    // }

    if ( session_status()!==PHP_SESSION_ACTIVE ) { session_start(); }

    if(isset($_SESSION['user_id'])) {
        // membre potentiellement loggé
        $potentialUser = $monUser->get_1User($_SESSION['user_id']);
        if($potentialUser) {
            // membre connecté
            $loggedUser = $potentialUser;
        }
    }

    return $loggedUser;
}

function logoutUser() {
    // if (isset($_COOKIE['session_token'])) {
    //     unset($_COOKIE['session_token']); 
    //     setcookie('session_token', null, time()-3600); 
    // }
    session_start();
    session_destroy();
}

?>