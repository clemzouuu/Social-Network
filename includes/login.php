<?php
// En cas de connexion
if(isset($_POST['submit']))  {

    $login = $_POST["id"];
    $passwordd = $_POST["password"];

    require("pdo.php");

    $maRequete = $pdo->prepare("SELECT * from twitter_id WHERE login = :login");  
    $maRequete->execute([
        ":login" => $login
    ]); 

    // Recherche si le mdp et le hash sont de paire
    if($maRequete->rowCount() > 0){
        $data = $maRequete->fetchAll();
        if(password_verify($passwordd,$data[0]["password"]) && $data[0]["actif"] == 1){   
            
            // La session est connecté, et il y a une redirection 
            $_SESSION["connecte"] = true;
            $_SESSION["login"] = $login; 
            $_SESSION["id"] = $data[0]["id"];
            http_response_code(302);
            header('Location: main.php');
            exit();
        }else if($data[0]["actif"] == 0){
            ?>
            <script type="text/javascript">
                alert("Compte désactivé")
            </script> 
            <?php
        }
        
    }
        
    }
?>
