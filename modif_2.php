<?php
require("supprimer.php");

if($_SERVER["REQUEST_METHOD"] == "POST")  {
    $name = filter_input(INPUT_POST, "name");
    $content = filter_input(INPUT_POST, "content"); 
    $admin = filter_input(INPUT_POST, "admin"); 
    $admin_id = filter_input(INPUT_POST, "admin_id"); 
    
    require("includes/pdo.php");

    // Si le mot de passe est changé, on l'update dans la base de donnée
    
    if($name) {
    
        $maRequete = $pdo->prepare("UPDATE groupe_2 SET name = :name WHERE group_id = :group_id");  
        $maRequete->execute([
            ":name" => $name,
            ":group_id" => $group_id
        ]);
    
    }

    if($content) {
    
        $maRequete = $pdo->prepare("UPDATE groupe_2 SET content = :content WHERE group_id = :group_id");  
        $maRequete->execute([
            ":content" => $content,
            ":group_id" => $group_id
        ]);
    
    }
    
    if($admin && $admin_id) {
        //$maRequete = $pdo->prepare("UPDATE groupe SET admin=:admin WHERE group_id = :group_id"); 
        $maRequete = $pdo->prepare("INSERT INTO admin_groupe (user,group_id) values(:user,:group_id)");     
        $maRequete->execute([
            ":user" => $admin,
            ":group_id" => $admin_id
        ]);
    
    }

    
}  
// Permet de modifier la photo de profil 
if (isset($_FILES['photo']['tmp_name'])) {
    $retour = copy($_FILES['photo']['tmp_name'], $_FILES['photo']['name']);
    if($retour) {
        $image = '<img src="' . $_FILES['photo']['name'] . '">';

        require("includes/pdo.php");

        $maRequete = $pdo->prepare("UPDATE groupe_2  SET profile_picture= :profile_picture WHERE group_id = :group_id");  
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

        $maRequete = $pdo->prepare("UPDATE groupe_2 SET seconde_picture= :second_picture WHERE group_id = :group_id");  
        $maRequete->execute([   
            ":second_picture" => $image2,
            ":group_id" => $group_id
        ]);
        $_SESSION["second_picture"] = $image2;
    }
}

?>