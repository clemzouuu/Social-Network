<?php

// Si on est en POST, alors on va chercher les infos dans le formulaire
if($_SERVER["REQUEST_METHOD"] == "POST")  {
    $login = filter_input(INPUT_POST, "login"); 
    $passwordd = filter_input(INPUT_POST, "mdp");
    $ville = filter_input(INPUT_POST, "city"); 
    $ecole = filter_input(INPUT_POST, "school"); 
    $specialite = filter_input(INPUT_POST, "cursus");  
    $age = filter_input(INPUT_POST, "age"); 
    $default = '<img src="img/Group_2.png">';
    $default_second = '<img src="img/default.png">';
    $actif = 1;

    
    // Si toutes le formulaire est rempli, alors on enregistre toutes les données dans la BDD
    if($login && $passwordd && $ville && $ecole && $specialite && $age) {
        $passwordd = password_hash(filter_input(INPUT_POST, "mdp"),PASSWORD_DEFAULT); // Hasher le mot de passe avant de l'entrer dans la bdd
        require("pdo.php");

        $maRequete = $pdo->prepare("INSERT INTO twitter_id (login,password,city,school,speciality,age,profile_picture,seconde_picture,actif) VALUES(:login,:password,:ville,:ecole,:specialite,:age,:profile_picture,:second_picture,:actif)");  
        $maRequete->execute([
            ":login" => $login,
            ":password" => $passwordd,
            ":ville" => $ville,
            ":ecole" => $ecole,
            ":specialite" => $specialite,
            ":age" => $age,
            ":profile_picture" => $default,
            ":second_picture" => $default_second,
            ":actif" => $actif
        ]);
        
 
        $_SESSION["connecte"] = true;
        $_SESSION["login"] = $login; 
        //$_SESSION["id"] = $data[0]["id"];
        $_SESSION["id"] = $pdo->lastInsertId();
        http_response_code(302);
        header('Location: main.php'); 
        exit(); 

    }
    
}  
?>
