<?php
// CONNEXION BDD
// Variables connexion
define('IN_PROD', true);
if(IN_PROD) {
  require_once __DIR__.'/config.php';
} else {
  require_once __DIR__.'/configProd.php';
}

try {
  $db = new PDO($serverBD, $userBD, $passBD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
  $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $err) {
  die('Echec connexion BLOGART : ' . $err->getMessage());
}
