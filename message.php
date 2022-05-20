<?php 
session_start();

 
$id = $_SESSION["id"];
$login = $_SESSION["login"];
require("includes/pdo.php");
 

// Page accessible seulement si $_SESSION["connecte"]
if(!$_SESSION["connecte"]) {
    http_response_code(302);
    header('Location: main.php');
    exit(); 
}

$getid = $_GET['id'];


$message = filter_input(INPUT_POST, "message");  
$maRequete = $pdo->prepare("SELECT * from twitter_id WHERE login = :login");  
$maRequete->execute([
    ":login" => $login
]); 

if(isset($_POST['envoyer'])){
    $message = htmlspecialchars($message);
    $insererMessage = $pdo->prepare("INSERT INTO message (name,content, id_destinataire, id_auteur) VALUES (:name,:message, :id_destinataire, :id_auteur)");
    $insererMessage -> execute([
        ":name" => $_SESSION["login"],
        ":message" => $message,
        ":id_destinataire" => $getid,
        ":id_auteur" => $_SESSION["id"]
    ]);
    header('Location: message.php?id=' . $getid);
    exit();
}

$modifier = filter_input(INPUT_POST, "modifier");  
$message_id = filter_input(INPUT_POST, "message_id");
$messagee_id = filter_input(INPUT_POST, "messagee_id");  

if($modifier && $message_id){
    $insererMessage = $pdo->prepare("UPDATE MESSAGE SET content=:modifier WHERE id=:message_id");
    $insererMessage -> execute([
        ":modifier" => $modifier,
        ":message_id" => $message_id,
    ]);

}

if($messagee_id){

    $insererMessage = $pdo->prepare("DELETE FROM message WHERE id=:message_id");
    $insererMessage -> execute([
        ":message_id" => $messagee_id
    ]);

}

?>

 <!DOCTYPE html>
 <html lang="fr">
 <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
     <style>
        <?php include "conversation.css" ?>
    </style>

 </head>
 <body>
     <div id="send">
     <form method="POST" action="">
         <textarea name="message">

         </textarea>
         <input type="submit" name="envoyer"><br><br>

         <input type="text" name="modifier" placeholder="Texte à modifier">
         <input type="text" name="message_id" placeholder="id message à modifier">
         <input type="text" name="messagee_id" placeholder="id message à supprimer">

     </form>
                
    </div>

        <section id="message"> 
        <?php $recupMessage = $pdo->prepare("SELECT * FROM message WHERE id_auteur =:id_auteur AND id_destinataire =:id_destinataire OR id_auteur = :id_destinataire");
        $recupMessage->execute([ 
            ":id_destinataire" => $getid,
            ":id_auteur" => $_SESSION["id"],
            
        ]);
        while($message = $recupMessage->fetch()){ 
            if($message['id_destinataire'] == $_SESSION['id']){ ?>
                 <p style="color:blue"><?="Ami :", $message['content']?></p> <?php
            } else {
                ?>
                 <p><?="N° ",$message['id']," Moi :", $message['content']?></p> <?php
            }
           
        }
        
        ?>

        </section>
        
        
    </div>
    
    <script>
         
function compteur () {
    let compteur = 0 // Met un timer
    let timer = setInterval(function () { // setInterval execute qq chose ap rès 1000ms
    compteur ++
    console.log(compteur)
    if (compteur == 4)
    { 
       window.location.reload()
    }
},1000)}
compteur()

       
    </script>

     
    
     
 </body>
 </html>