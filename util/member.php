<?php

require_once __DIR__ . '/../class_crud/membre.class.php';

function getLoggedMemberOrFalse() {
    $monMembre = new membre();
    $loggedMember = false;

    // if(isset($_COOKIE['session_token'])) {
    //     // membre potentiellement loggé
    //     $potentialToken = customDecrypt($_COOKIE['session_token']);
    //     $data = explode('.', $potentialToken);
    
    //     if(count($data) > 2 AND $data[0] === "true") { // le token est valide
    //         $numMemb = intval($data[1]);
    
    //         $potentialMember = $monMembre->get_1Membre($numMemb);
    //         if($potentialMember) {
    //             // membre connecté
    //             $loggedMember = $potentialMember;
    //         }
    //     }
    // }

    if ( session_status()!==PHP_SESSION_ACTIVE ) { session_start(); }

    if(isset($_SESSION['member_id'])) {
        // membre potentiellement loggé
        $potentialMember = $monMembre->get_1Membre($_SESSION['member_id']);
        if($potentialMember) {
            // membre connecté
            $loggedMember = $potentialMember;
        }
    }

    return $loggedMember;
}

function logoutMember() {
    // if (isset($_COOKIE['session_token'])) {
    //     unset($_COOKIE['session_token']); 
    //     setcookie('session_token', null, time()-3600); 
    // }
    session_start();
    session_destroy();
}

?>