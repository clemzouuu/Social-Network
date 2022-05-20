<?php 
    $engine = "mysql";
    $host = "localhost";
    $port = 8889;
    $dbname = "twitter_db"; // Changer le nom
    $username = "root";
    $password = "root";

    $pdo = new PDO("$engine:host=$host:$port;dbname=$dbname", $username, $password);

?>