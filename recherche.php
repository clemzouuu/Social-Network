<?php 

$search = filter_input(INPUT_POST, "search"); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        <?php include "recherche.css"?>
    </style>
    
</head>
<body>
        <div id="recherche">
            <form method="POST">
                <input type="text" placeholder="Rechercher" name="search"/>
                <input type="submit" value="Envoyer"/>

            </form>
        </div>
                <?php 
                    require("includes/pdo.php");
                    $marequete = $pdo->prepare("SELECT * FROM twitter_id WHERE login LIKE '%$search%'");
                    $marequete->execute();
                    $categories = $marequete->fetchAll();
                    if($search){ 
                        foreach($categories as $categori){ ?>
                            <div id="info">
                            <td><?=$categori["profile_picture"]?><br><br>
                            <td><?= $categori["login"]?></td><br><br>
                            <td><?=$categori['city']?></td><br><br>
                            <td><?=$categori["school"]?></td><br><br>
                            <td><?=$categori["speciality"]?></td><br><br>
                            <td><?="Âge ",$categori["age"]?></td> 
                            
                            <?php
                        }?>
                        </div>
                        

                        
                    <input type="submit" value="Ajouter en ami" id="submit"/>
                        
                        
                <?php
                    }
                 ?>
                 
                
   

</body>
</html>