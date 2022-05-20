<?php 
session_start();

// Page accessible seulement si $_SESSION["connecte"]
if(!$_SESSION["connecte"]) {   //    Demander l'accessibilité 
    http_response_code(302);
    header('Location: login_page.php');
    exit(); 
}


$id = $_SESSION["id"];
$login = $_SESSION["login"];



if($_SERVER["REQUEST_METHOD"] == "POST")  {
    $group = filter_input(INPUT_POST, "group_name"); 
    $content = filter_input(INPUT_POST, "content"); 
    $default = '<img src="img/Group_2.png">';
    $default_second = '<img src="img/default.png">';
    
        if($group && $content) {

            require("includes/pdo.php");
            $maRequetee = $pdo->prepare("INSERT INTO groupe (name,id,content,profile_picture,seconde_picture,admin) values (:name,:id,:content,:profile_picture,:seconde_picture,:admin)");  
            $maRequetee->execute([
                ":id" => $id,
                ":name" => $group,
                ":content" => $content,
                ":profile_picture" =>$default,
                ":seconde_picture" => $default_second,
                ":admin" => $login,
            ]);
            
            $group_id = $pdo->lastInsertId();

            $marequet = $pdo->prepare("INSERT INTO admin (user,group_id) values(:id,:group_id)");  
            $marequet->execute([
                ":id" => $id,
                ":group_id" => $group_id
            ]);

            header('Location: main.php');
            exit();
        }
        

    }

    

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Network</title>
    <style>
        <?php include "creer_page_groupe.css"?>
    </style>
</head>
    <body>

    <div id="content">

        <form method="post">
            <label for="text">Nom de groupe</label>

            <input type="text" name="group_name" id="mdp" /><br/><br>

            <label for="text">Descirption de groupe</label>
            <textarea name="content"></textarea><br/><br>
            <input type="submit" value="Enregistrer" class="button" id="submit"/>
        </form>

    
    </div>


        
</body>
</html>