<?php 

session_start();
$id = $_SESSION["id"];



// Page accessible seulement si $_SESSION["connecte"]
if(!$_SESSION["connecte"]) {   //    Demander l'accessibilité 
    http_response_code(302);
    header('Location: login_page.php');
    exit(); 

    
}

$group_id = filter_input(INPUT_GET, "group_id", FILTER_VALIDATE_INT);


require("includes/pdo.php");


$maret = $pdo->prepare("SELECT * FROM membre_groupe_prive WHERE group_id = :group_id AND membre =0");  
$maret->execute([
    ":group_id" => $group_id
]);
$catet = $maret->fetch();



$marequetee = $pdo->prepare("SELECT * FROM groupe_prive WHERE group_id = :group_id");  
$marequetee->execute([
    ":group_id" => $group_id
]);
$categoriess = $marequetee->fetchAll();


$ma= $pdo->prepare("SELECT * FROM admin_groupe_prive WHERE group_id = :group_id");  
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

<?="Id user qui veut rejoindre",$catet["user"] ?>

<?php foreach($c as $i): ?> 
<?php if ($i["user"] == $id){
               require("modif_prive.php");
            } ?>
        <?php endforeach; ?>

    <form method="post" enctype="multipart/form-data">
    <div id="page">
        <?php foreach($categoriess as $categori): ?> 
            
                <td><?= $categori["name"]?></td><br><br>
                <td><?= $categori["profile_picture"]?></td><br>
                
            <?php endforeach; ?>
    </div>

            <form method="POST">
    <div id="modifier">
<label for="login">Ajouter un membre</label>
            <input type="text" name="admin" placeholder="id du membre"/><br/>

            <label for="login">Ajouter l'id du groupe</label>
            <input type="text" name="admin_id" placeholder="id du groupe"/><br/><br/>
</form>


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

            <label for="login">Accepter un membre</label>
            <input type="text" name="membre" placeholder="id du membre"/><br/>

            <label for="login">Entrez l'id du groupe</label>
            <input type="text" name="membre_id" placeholder="id du groupe"/><br/><br/>

            <label for="login">Ajouter un membre</label>
            <input type="text" name="add_membre" placeholder="id du membre"/><br/>

            <label for="login">Ajouter l'id du groupe</label>
            <input type="text" name="add_membre_id" placeholder="id du groupe"/><br/><br/>

            <label for="login">Supprimer un admin</label>
            <input type="text" name="delete_admin" placeholder="id de l'admin"/><br/>

            <label for="login">Entrez l'id du groupe</label>
            <input type="text" name="delete_admin_id" placeholder="id du groupe"/><br/><br/>

            <label for="login">Supprimer une invitation</label>
            <input type="text" name="delete_membership" placeholder="id du demandeur"/><br/>

            <label for="login">Supprimer un membre</label>
            <input type="text" name="delete_member" placeholder="Entrez son nom"/><br/>



            <input type="submit" value="Enregistrer" class="button" id="submit"/>
        </form>
    </form>
    </div>




</body>
</html>