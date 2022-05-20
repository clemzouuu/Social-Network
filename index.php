<?php session_start(); 
require("includes/login.php");
require("includes/sign_in.php");
$_SESSION["connecte"] = false;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Network</title>
    <style>
        <?php include "login.css" ?>
    </style>

</head>
<body>
    <header>
        <img src="img/Group_2.png" alt="logo_social_network" height="150px" width ="150px">
        <p style="font-size:30px">E-Notion</p>
        <p>Partagez vos connaissances !</p>
    </header>


    <div class="box">
        <h1>Inscription</h1>
        <div class="inscription">

            <form method="POST">
                <label for="login">Pseudo</label>
                <input type="text" name="login" id="id"/><br/>

                <label for="password">Mot de passe</label>
                <input type="password" name="mdp" id="mdp" /><br/>

                <label for="login">Ville</label>
                <input type="text" name="city" placeholder="Ex : Paris "/><br/>

                <label for="login">Ecole</label>
                <input type="text" name="school" placeholder="Ex : Hetic"/><br/>

                <label for="login">Specialité</label>
                <input type="text" name="cursus" placeholder="Ex : Dev web"/><br/>

                <label for="login">Âge</label>
                <input type="text" name="age"/><br/>

                <input type="submit" value="Enregistrer" class="button" id="submit"/>
            </form>
        </div>

        <h1>Connexion</h1>
        <div class="connexion">
            <form method="POST">
                <label for="login">Identifiant</label>
                <input type="text" name="id" id="login" /><br/>

                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" /><br/>

                <a href="reactiver.php">Reactiver un compte</a>
                <input type="submit" name="submit" value="Se connecter" class="button" />
            </form>
        </div> 
    </div>

</body>
</html>