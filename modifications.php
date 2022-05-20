<?php

$id = $_SESSION["id"];

// Modification des informations personnelles 
if($_SERVER["REQUEST_METHOD"] == "POST")  {
    $passwordd = filter_input(INPUT_POST, "motdepasse");
    $ville = filter_input(INPUT_POST, "ville"); 
    $ecole = filter_input(INPUT_POST, "ecole"); 
    $specialite = filter_input(INPUT_POST, "specialite");  
    
    require("includes/pdo.php");

    // Si le mot de passe est changé, on l'update dans la base de donnée
    if($passwordd) {
    
        $maRequete = $pdo->prepare("UPDATE twitter_id SET password = :password WHERE id = :id");  
        $maRequete->execute([
            ":password" => $passwordd,
            ":id" =>$id
        ]);
    }

    // Données sont traitées individuellement car on les traite en groupe, mais qu'elles ne sont pas toutes changées, les données non-modifiées seront rempalcée par " " dans la bdd
    if($ville) {
    
        $maRequete = $pdo->prepare("UPDATE twitter_id SET city= :ville WHERE id = :id");  
        $maRequete->execute([
            ":ville" => $ville,
            ":id" =>$id
        ]);
        $_SESSION["ville"] = $ville;
    }

    if($ecole) {
    
        $maRequete = $pdo->prepare("UPDATE twitter_id SET school = :ecole WHERE id = :id");  
        $maRequete->execute([
            ":ecole" => $ecole,
            ":id" =>$id
        ]);
        $_SESSION["ecole"] = $ecole;
    }

    if($specialite) {
    
        $maRequete = $pdo->prepare("UPDATE twitter_id SET speciality = :specialite WHERE id = :id");  
        $maRequete->execute([
            ":specialite" => $specialite,
            ":id" =>$id
        ]);
        $_SESSION["specialite"] = $specialite;
    }
    
}  
// Permet de modifier la photo de profil 
if (isset($_FILES['photo']['tmp_name'])) {
    $retour = copy($_FILES['photo']['tmp_name'], $_FILES['photo']['name']);
    if($retour) {
        $image = '<img src="' . $_FILES['photo']['name'] . '">';

        require("includes/pdo.php");

        $maRequete = $pdo->prepare("UPDATE twitter_id  SET profile_picture= :profile_picture WHERE id = :id");  
        $maRequete->execute([   
            ":profile_picture" => $image,
            ":id" =>$id
        ]);
        $_SESSION["profile_picture"] = $image;
    }

}

// Permet de modifier la photo de couverture
if (isset($_FILES['photo2']['tmp_name'])) {
    $retour = copy($_FILES['photo2']['tmp_name'], $_FILES['photo2']['name']);
    if($retour) {
        $image2 = '<img src="' . $_FILES['photo2']['name'] . '">';

        require("includes/pdo.php");

        $maRequete = $pdo->prepare("UPDATE twitter_id  SET seconde_picture= :second_picture WHERE id = :id");  
        $maRequete->execute([   
            ":second_picture" => $image2,
            ":id" =>$id
        ]);
        $_SESSION["second_picture"] = $image2;
    }
}

?>