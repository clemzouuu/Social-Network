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
    require("modifications.php");


    // Afficher les informations de chaque utilisateur 
    require("includes/pdo.php");
    $marequete = $pdo->prepare("SELECT * FROM twitter_id where id = :id");  
    $marequete->execute([
        ":id" =>$id
    ]);
    $categories = $marequete->fetchAll();


    $marequet = $pdo->prepare("SELECT name,content,created FROM all_twits WHERE id =:id");
    $marequet->execute([
        ":id" => $id
    ]);
    $categoris = $marequet->fetchAll();

    $desactiver = filter_input(INPUT_POST, "desactiver"); 

    if($desactiver){
        $marequet = $pdo->prepare("UPDATE twitter_id SET actif =0 WHERE id = :id");
        $marequet->execute([
        ":id" => $id
    ]);
    $_SESSION["connecte"] = false;
    http_response_code(302);
    header('Location: index.php'); 
    exit(); 
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
        <?php include "styles_2.css"?>
    </style>
</head>
    <body>

    <header>
        <div id="second_picture">
            <?php foreach($categories as $categorie): ?>
                <tr>
                    <td><?= $categorie["seconde_picture"]?></td>
                </tr>
            <?php endforeach; ?>
        </div>

        <div id="profile_picture">
        <?php foreach($categories as $categorie): ?>
            <tr>
                <td><?= $categorie["profile_picture"]?></td>
            </tr>
        <?php endforeach; ?>
        </div>
    </header>

    
    <div id="content">
        
        <div id="modifications">
        
            <a href="main.php">Retour au profil</a>
            <a href="index.php">Deconnexion</a>
            <a href="includes/supprimer.php">Supprimer le compte</a>

            <form method="POST">
                <label for="desactiver">Desactiver le compte</label>
                <input type="input" name="desactiver" placeholder="Entrez votre pseudo">
            </form>

            <form method="post" enctype="multipart/form-data">
                <span>Modifier la photo de profil </span><input type="file" name="photo">
                <input type="submit">
            </form>

            <form method="post" enctype="multipart/form-data">
                <span>Modifier la photo de couverture </span><input type="file" name="photo2">
                <input type="submit">
            </form>

            <form method="post">
                <label for="password">Modifier le mot de passe</label>
                <input type="password" name="motdepasse" id="mdp" /><br/>

                <label for="login">Modifier la ville</label>
                <input type="text" name="ville"/><br/>

                <label for="login">Modifier l'école</label>
                <input type="text" name="ecole"/><br/>

                <label for="login">Modifier la specialité</label>
                <input type="text" name="specialite"/><br/>

                <input type="submit" value="Enregistrer" class="button" id="submit"/>
            </form>
        </div>

     
        <div id="tweet">
            <?php foreach($categoris as $categori): ?>
                <tr>
                    <td><?=$categori["content"]?></td><br>
                    <td><?= $categori["name"] ?></td>
                    <td><?= $categori["created"] ?></td><br><br>
                    
                </tr>
            <?php endforeach; ?>
        </div>
    </div>


</body>
</html>