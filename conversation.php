<?php 
    session_start();

    require("includes/pdo.php");
    

    if(!$_SESSION["connecte"]) {
        http_response_code(302);
        header('Location: main.php');
        exit(); 
    }
    $id = $_SESSION["id"];

    $marequetee = $pdo->prepare("SELECT * FROM twitter_id WHERE NOT id=:id");  
    $marequetee->execute([
        ":id" => $id
    ]);
    $categoriess = $marequetee->fetchAll();


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    <?php include "styles.css" ?>
</style>
</head>

    <body>

    <div id="infos">
        <p>Démarrer une conversation avec vos amis</p>
        <?php foreach($categoriess as $categori): ?>
            <tr>
                <a href="message.php?id=<?=$categori['id']?>">
                    <td><?=$categori['login'] ?></td>
                </a>
                <br>
            </tr>
        <?php endforeach; ?> 
            
    </div>
    
    </body>
</html>