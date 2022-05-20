<?php 
require("pdo.php");
require("../index_2.php");
$id = $_SESSION["id"];

$maRequete = $pdo->prepare("DELETE FROM twitter_id WHERE id = :id");
$maRequete->execute([
    ":id" => $id,
]);


http_response_code(302);  
header('Location:../index.php'); // On dit au navig où être rediriger
exit(); // Après une redirection, on appelle exit(); 
?>

