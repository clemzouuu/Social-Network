<?php 

session_start();
$id = $_SESSION["id"];
$group_id = filter_input(INPUT_GET, "group_id", FILTER_VALIDATE_INT);

$login = $_SESSION["login"];


// Page accessible seulement si $_SESSION["connecte"]
if(!$_SESSION["connecte"]) {   //    Demander l'accessibilité 
    http_response_code(302);
    header('Location: login_page.php');
    exit(); 
}


require("includes/pdo.php");

$marequetee = $pdo->prepare("SELECT * FROM groupe_prive WHERE group_id = :group_id");  
$marequetee->execute([
    ":group_id" => $group_id
]);
$categoriess = $marequetee->fetchAll();

$m = $pdo->prepare("SELECT name,group_id from groupe_prive WHERE group_id = :group_id");  
$m->execute([
    ":group_id" => $group_id
]);
$c = $m->fetch();

$group_id = filter_input(INPUT_GET, "group_id", FILTER_VALIDATE_INT);

$marequete = $pdo->prepare("SELECT name,content,created,answer,answering_person,tweet_id FROM all_tweets_groupe_prive ORDER BY created DESC");
$marequete->execute();
$categories = $marequete->fetchAll();



$ma= $pdo->prepare("SELECT * FROM membre_groupe_prive WHERE group_id = :group_id");  
$ma->execute([
    ":group_id" => $group_id
]);
$cc = $ma->fetchAll();



foreach($cc as $i):
if ($i["user"] == $id && ($i["membre"] == 1 || $i["membre"] ==2)){
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $tweet = filter_input(INPUT_POST, "tweet"); 
        $answer = filter_input(INPUT_POST, "answer"); 
        $tweet_number = filter_input(INPUT_POST, "tweet_number"); 
        
        
            if($tweet) {
                $maRequetee = $pdo->prepare("INSERT INTO all_tweets_groupe_prive (id,content,name,group_id) values (:id,:content,:name,:group_id)");  
                $maRequetee->execute([
                    ":id" => $id,
                    ":content" => $tweet,
                    ":name" => $login,
                    ":group_id" => $group_id
                ]);
                header('Location: afficher_groupe_prive.php?group_id='.$group_id);
                exit();
            }
        
            if($answer) {
                $maR = $pdo->prepare("INSERT INTO tweet_answers_groupe_prive  (name,content,tweet_id) values(:pseudo,:content,:tweet)");  
         
                $maR->execute([
                    ":content" => $answer,
                    ":pseudo" => $_SESSION["login"],
                    ":tweet" => $tweet_number
                ]);
            }
        
        }    


    } 
 endforeach; 

$membre = filter_input(INPUT_POST, "membre"); 
$membre_id = filter_input(INPUT_POST, "membre_id"); 
$number = 0;

if($membre && $membre_id) {
    //$maRequete = $pdo->prepare("UPDATE groupe SET admin=:admin WHERE group_id = :group_id"); 
    $maRequete = $pdo->prepare("INSERT INTO membre_groupe_prive (user,group_id,membre) values(:user,:group_id,:membre)");     
    $maRequete->execute([
        ":user" => $membre,
        ":group_id" => $membre_id,
        ":membre" =>$number
    ]);

}
        

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        <?php include "afficher_page_groupe.css"?>
    </style>
</head>
<body>

<?php

$mx= $pdo->prepare("SELECT * FROM membre_groupe_prive WHERE group_id = :group_id AND user = :user_id");  
$mx->execute([
    ":group_id" => $group_id,
    ":user_id" => $id
]);

$groupMembership = $mx->fetch(); ?>

<?php if ($groupMembership["membre"] >= 1){ ?>
    <div id="tweet">
        <form method="POST">
            <input type="text" name="tweet" id="submit1" placeholder="Exprimez vous !"/>
            <input type="submit" value="Envoyer" id="submit"/>
        </form>
    </div>

        <?php foreach($categoriess as $categori): ?> 
            <div id="picture">
                <div id="first_picture">
                    <td><?= $categori["profile_picture"]?></td><br>
                </div>
                <div id="second_picture">
                    <td><?= $categori["seconde_picture"]?></td><br>
                </div>
            </div>
            <div id="main_2">
                <td><?= $categori["name"]?></td><br>
            </div>
        <?php endforeach; ?>

        <div id="content">
            <p>Tous les tweets</p>
            <?php foreach($categories as $categorie): ?>
                <tr>
                    <form method="POST">
                        <?= "Tweet N°",$categorie["tweet_id"]?></td><br>
                        <td><?= $categorie["content"] ?></td><br>
                        <td><?=$categorie['name'],", " ?></td>
                        <td><?="à ",$categorie["created"] ?></td><br>
                        <?php 
                            $mareq = $pdo->prepare("SELECT name,content FROM tweet_answers_groupe_prive WHERE tweet_id=:tweet");
                            $mareq->execute([
                                ":tweet" => $categorie["tweet_id"]
                            ]);
                            $catp = $mareq->fetch();
                            if($catp) echo "Réponse de ",$catp["name"]," : ",$catp["content"];
                        ?>
                        <br><br>
                    </form>
                </tr>
            <?php endforeach; ?>
        </div>
            <div id="commenter">
                <form method="POST">
                    <input type="text" name="answer" placeholder="Commentez"/>
                    <input type="text" name="tweet_number">
                    <input type="submit" value="Commentez" />
                </form>
            </div>
            
            <div id="lien">               
                <a href="modifier_groupe_prive.php?group_id=<?=$c["group_id"] ?>"> 
                    Modifier le groupe </a><br> 
            </div>
    <?php } else {
        echo "Vous n'êtes pas membre de ce groupe"; ?>
            <form method="POST">
            <p>Pour rejoindre le groupe, entrez votre identifiant</p>
            <label for="login">Ajouter un membre</label>
            <input type="text" name="membre" placeholder="id de l'admin"/><br/>

            <label for="login">Ajouter l'id du membre</label>
            <input type="text" name="membre_id" placeholder="id du groupe"/><br/>
            <input type="submit" value="Enregistrer" class="button" id="submit"/>
            </form>
        <?php 
    } ?>


                
           


</body>
</html>