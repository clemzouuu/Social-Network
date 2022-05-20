<?php
$a = 30;
echo json_encode($a);

require("includes/pdo.php");
$recupMessage = $pdo->prepare("SELECT * FROM message WHERE id_auteur =:id_auteur AND id_destinataire =:id_destinataire OR id_auteur = :id_destinataire");
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