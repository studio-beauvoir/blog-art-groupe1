<?php
require_once __DIR__ . '/../connect/database.php';


function isUnique($table, $value, $column, $exceptSelf=false) {
    global $db;

    $db->beginTransaction();
    try {
        $query = 'SELECT * FROM '.$table.' WHERE '.$column.'=?;';
        $request = $db->prepare($query);
        
        $request->execute([$value]);

        $rowCount = $request->rowCount();

        $db->commit();
		$request->closeCursor();

        if($exceptSelf) {
            // on accepte que la valeur passée existe et soit unique
            // il peut en exister 1 max
            // utilisé dans le cas d'un update
            
            return $rowCount <= 1;
        } else { 
            // sinon
            // il ne peut en exister aucun
            // utilisé dans le cas d'un create
            return $rowCount <= 0;
        }
    }
    catch (PDOException $e) {
        $db->rollBack();
        $request->closeCursor();
        die('Erreur verifying unique : ' . $e->getMessage());
    }
}