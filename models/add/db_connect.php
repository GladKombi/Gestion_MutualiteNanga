<?php
$dsn = 'mysql:host=localhost;dbname=gestion_mutuelite;charset=utf8mb4';
$username = 'root'; 
$password = ''; 

try {
    // Créer une nouvelle instance de PDO
    $conn = new PDO($dsn, $username, $password);

    // Définir le mode d'erreur de PDO pour qu'il lance des exceptions en cas de problème
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Gérer les erreurs de connexion
    die("Erreur de connexion : " . $e->getMessage());
}
?>