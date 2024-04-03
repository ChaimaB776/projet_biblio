<?php
// Informations de connexion à la base de données
$host = "localhost"; 
$db_name = "biblio"; 
$username = "user"; 
$password = "user12345"; 

try {
    // Création de la connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8mb4", $username, $password);
    
    // Configuration des options de PDO pour afficher les erreurs
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    // En cas d'erreur de connexion, message d'erreur
    error_log("Erreur de connexion à la base de données : " . $e->getMessage());
    http_response_code(500);
    echo "Une erreur est survenue. Veuillez réessayer plus tard.";
    exit();
}
?>