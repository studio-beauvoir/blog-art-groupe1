<?php
require_once __DIR__ . '../../connect/database.php';

class search{
    function get_SearchByMotCle($motcle){
        global $db;
        $query = 'SELECT motcle.*, motclearticle.*, article.numArt,article.libTitrArt, article.libChapoArt, article.urlPhotArt FROM motcle 
            JOIN motclearticle ON motcle.numMotCle = motclearticle.numMotCle
            JOIN article ON motclearticle.numArt = article.numArt
            WHERE motcle.libMotCle LIKE "%?%" ' ;
        $request = $db->prepare($query);
        $request->execute([$motcle]);
        $articles = $request->fetchAll();
        return $articles;
    }
}