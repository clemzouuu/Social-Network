<?php 

    session_start();
    $id = $_SESSION["id"];
    require("includes/pdo.php");

    if(!$_SESSION["connecte"]) {   
        http_response_code(302);
        header('Location: login_page.php');
        exit(); 
    }

    $group_id = filter_input(INPUT_GET, "group_id", FILTER_VALIDATE_INT);


    $marequetee = $pdo->prepare("SELECT * FROM groupe WHERE group_id = :group_id");  
    $marequetee->execute([
        ":group_id" => $group_id
    ]);
    $categoriess = $marequetee->fetchAll();


    $ma= $pdo->prepare("SELECT * FROM admin WHERE group_id = :group_id");  
    $ma->execute([
        ":group_id" => $group_id
    ]);

    $c = $ma->fetchAll();




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        <?php include "modifier_page_groupe.css"?>
    </style>
</head>
<body>

    <form method="post" enctype="multipart/form-data">
        <div id="page">
            <?php foreach($categoriess as $categori): ?> 
                    <td><?= $categori["profile_picture"]?></td><br><br>
                    <td><?= $categori["name"]?></td><br>
                    <td><?= $categori["content"]?></td><br>
                    
            <?php endforeach; ?>
        </div>
        

            <?php foreach($c as $i): ?> 

            <?php if ($i["user"] == $id){
               require("modif.php");
            } ?>

        <?php endforeach; ?>

            <div id="modifier">
            <form method="post" enctype="multipart/form-data">
            <span>Modifier la photo de profil </span><input type="file" name="photo">
            <input type="submit">
        </form>

        <form method="post" enctype="multipart/form-data">
            <span>Modifier la photo de couverture </span><input type="file" name="photo2">
            <input type="submit">
        </form><br/>

        <form method="post">
            <label for="text">Modifier le nom de la page </label>
            <input type="text" name="name" id="name" /><br/>

            <label for="login">Modifier sa description</label>
            <input type="text" name="content"/><br/><br/>

            <label for="login">Ajouter un admin</label>
            <input type="text" name="admin" placeholder="id de l'admin"/><br/>

            <label for="login">Ajouter l'id du groupe</label>
            <input type="text" name="admin_id" placeholder="id du groupe"/><br/><br/>

            <label for="login">Supprimer un admin</label>
            <input type="text" name="delete_admin" placeholder="id de l'admin"/><br/>

            <label for="login">Entrez l'id du groupe</label>
            <input type="text" name="delete_admin_id" placeholder="id du groupe"/><br/><br/>


            <input type="submit" value="Enregistrer" class="button" id="submit"/>
        </form>
    </form>
    </div>
           




</body>
</html>