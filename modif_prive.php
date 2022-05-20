<?php
require("supprimer.php");

if($_SERVER["REQUEST_METHOD"] == "POST")  {
    $name = filter_input(INPUT_POST, "name");
    $content = filter_input(INPUT_POST, "content"); 
    $admin = filter_input(INPUT_POST, "admin"); 
    $admin_id = filter_input(INPUT_POST, "admin_id"); 
    $membre = filter_input(INPUT_POST, "membre"); 
    $add_membre_id = filter_input(INPUT_POST, "add_membre_id"); 
    $add_membre = filter_input(INPUT_POST, "add_membre"); 
    $add_membre_number = 1;
    $membre_id = filter_input(INPUT_POST, "membre_id"); 
    $delete_membreship = filter_input(INPUT_POST, "delete_membership"); 
    $delete_membre = filter_input(INPUT_POST, "delete_member"); 
    
    require("includes/pdo.php");

    // Si le mot de passe est changé, on l'update dans la base de donnée
    
    if($name) {
    
        $maRequete = $pdo->prepare("UPDATE groupe_prive SET name = :name WHERE group_id = :group_id");  
        $maRequete->execute([
            ":name" => $name,
            ":group_id" => $group_id
        ]);
    
    }

    if($content) {
    
        $maRequete = $pdo->prepare("UPDATE groupe_prive SET content = :content WHERE group_id = :group_id");  
        $maRequete->execute([
            ":content" => $content,
            ":group_id" => $group_id
        ]);
    
    }
    
    if($admin && $admin_id) {
        //$maRequete = $pdo->prepare("UPDATE groupe SET admin=:admin WHERE group_id = :group_id"); 
        $maRequete = $pdo->prepare("INSERT INTO admin_groupe_prive (user,group_id) values(:user,:group_id)");     
        $maRequete->execute([
            ":user" => $admin,
            ":group_id" => $admin_id
        ]);
    
    }

    if($membre && $membre_id) {
        //$maRequete = $pdo->prepare("UPDATE groupe SET admin=:admin WHERE group_id = :group_id"); 
        $maRequete = $pdo->prepare("UPDATE membre_groupe_prive SET membre=1 WHERE user=:user AND group_id=:group_id");     
        $maRequete->execute([
            ":user" => $membre,
            ":group_id" => $membre_id
        ]);
    
    }

    if($add_membre && $add_membre_id) {
        $maRequete = $pdo->prepare("INSERT INTO membre_groupe_prive (user,group_id,membre) values(:user,:group_id,:membre)");     
        $maRequete->execute([
            ":user" => $add_membre,
            ":group_id" => $add_membre_id,
            ":membre" => $add_membre_number
            
        ]);
    
    }

    if($delete_membreship) {
        //$maRequete = $pdo->prepare("UPDATE groupe SET admin=:admin WHERE group_id = :group_id"); 
        $maRequete = $pdo->prepare("DELETE FROM membre_groupe_prive WHERE user=:user AND membre = 0");     
        $maRequete->execute([
            ":user" => $delete_membreship
        ]);
    
    }

    if($delete_membre) {
        //$maRequete = $pdo->prepare("UPDATE groupe SET admin=:admin WHERE group_id = :group_id"); 
        $maRequete = $pdo->prepare("DELETE FROM membre_groupe_prive WHERE user=:user");     
        $maRequete->execute([
            ":user" => $delete_membre
        ]);
    
    }

    
}  
// Permet de modifier la photo de profil 
if (isset($_FILES['photo']['tmp_name'])) {
    $retour = copy($_FILES['photo']['tmp_name'], $_FILES['photo']['name']);
    if($retour) {
        $image = '<img src="' . $_FILES['photo']['name'] . '">';

        require("includes/pdo.php");

        $maRequete = $pdo->prepare("UPDATE groupe_prive  SET profile_picture= :profile_picture WHERE group_id = :group_id");  
        $maRequete->execute([   
            ":profile_picture" => $image,
            ":group_id" => $group_id
        ]);
        $_SESSION["profile_picture"] = $image;
    }

}

// Permet de modifier la photo de couverture
if (isset($_FILES['photo2']['tmp_name'])) {
    $retour = copy($_FILES['photo2']['tmp_name'], $_FILES['photo2']['name']);
    if($retour) {
        $image2 = '<img src="' . $_FILES['photo2']['name'] . '">';

        require("includes/pdo.php");

        $maRequete = $pdo->prepare("UPDATE groupe_prive SET seconde_picture= :second_picture WHERE group_id = :group_id");  
        $maRequete->execute([   
            ":second_picture" => $image2,
            ":group_id" => $group_id
        ]);
        $_SESSION["second_picture"] = $image2;
    }
}

?>