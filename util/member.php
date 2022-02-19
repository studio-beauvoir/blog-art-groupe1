<?php

require_once __DIR__ . '/../CLASS_CRUD/membre.class.php';

function getLoggedMemberOrFalse() {
    $monMembre = new MEMBRE();
    $loggedMember = false;

    if(isset($_COOKIE['session_token'])) {
        // membre potentiellement loggé
        $potentialToken = customDecrypt($_COOKIE['session_token']);
        $data = explode('.', $potentialToken);
    
        if(count($data) > 2 AND $data[0] === "true") { // le token est valide
            $numMemb = intval($data[1]);
    
            $potentialMember = $monMembre->get_1Membre($numMemb);
            if($potentialMember) {
                // membre connecté
                $loggedMember = $potentialMember;
            }
        }
    }

    return $loggedMember;
}

function logout() {
    if (isset($_COOKIE['session_token'])) {
        unset($_COOKIE['session_token']); 
        setcookie('session_token', null, time()-3600); 
    }
}

?>