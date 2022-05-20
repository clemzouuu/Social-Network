<?php
    $delete_admin = filter_input(INPUT_POST, "delete_admin"); 
    $delete_admin_id = filter_input(INPUT_POST, "delete_admin_id"); 

    if($delete_admin && $delete_admin_id) {
        //$maRequete = $pdo->prepare("UPDATE groupe SET admin=:admin WHERE group_id = :group_id"); 
        $maRequete = $pdo->prepare("DELETE FROM admin WHERE user =:delete_admin");     
        $maRequete->execute([
            ":delete_admin" => $delete_admin
        ]);
    
    }
?>