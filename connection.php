<?php
$host = "localhost";    
$user = "root";      
$pass = "root";          
$dbname = "portfolio"; 

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    
    // Configuration de PDO pour gérer les erreurs et récupérer les données sous forme de tableau associatif
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
