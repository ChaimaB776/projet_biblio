<?php
include 'bdd.php';

// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["username"])) {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: connexion.php");
    exit();
}

// Définir des variables pour stocker les messages
$errorMsg = "";
$successMsg = "";

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les nouvelles informations de l'utilisateur depuis le formulaire
    $oldPassword = $_POST["old_password"];
    $newPassword = $_POST["new_password"];
    $confirmPassword = $_POST["confirm_password"];

    // Vérifier si le mot de passe actuel correspond à celui stocké en base de données
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :userId AND password = :password");
    $stmt->execute(array(':userId' => $_SESSION["users_id"], ':password' => $oldPassword));
    $user = $stmt->fetch();

    if (!$user) {
        // Stocker un message d'erreur dans une variable de session
        $_SESSION["error"] = "Mot de passe actuel incorrect.";
    } elseif ($newPassword !== $confirmPassword) {
        // Stocker un message d'erreur dans une variable de session
        $_SESSION["error"] = "La confirmation du mot de passe ne correspond pas.";
    } else {
        // Mettre à jour le mot de passe dans la base de données
        $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :userId");
        $stmt->execute(array(':password' => $newPassword, ':userId' => $_SESSION["users_id"]));

        // Stocker un message de succès dans une variable de session
        $_SESSION["success"] = "Mot de passe modifié avec succès.";
    }

    // Rediriger l'utilisateur vers la page compte.php
    header("Location: compte.php");
    exit();
}

// Vérifier s'il y a des messages d'erreur ou de succès dans la session
if (isset($_SESSION["error"])) {
    $errorMsg = $_SESSION["error"];
    unset($_SESSION["error"]); // Supprimer le message d'erreur de la session
}

if (isset($_SESSION["success"])) {
    $successMsg = $_SESSION["success"];
    unset($_SESSION["success"]); // Supprimer le message de succès de la session
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier les informations</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
        <nav>
            <ul>
                <li><a href="index.php"><img src="img/logo.png" alt="Logo de l'entreprise"></a></li>
                <li class="titre"><h1>Librairie </h1></li>
                <li class="produit"><a href="index.php" style="color:#4c6be6;">Accueil</a></li>
                <li class="produit"><a href="connexion.php" style="color:#4c6be6;">Connexions</a></li>
                <li class="produit"><a href="favoris.php" style="color:#4c6be6;">Favoris</a></li>
            </ul>
 
        </nav>
    </header>

    <h1>Modifier vos informations</h1>

    <form action="compte.php" method="post">
    <label for="old_password">Ancien mot de passe :</label>
    <input type="password" id="old_password" name="old_password" required><br><br>

    <label for="new_password">Nouveau mot de passe :</label>
    <input type="password" id="new_password" name="new_password" required><br><br>

    <label for="confirm_password">Confirmer le nouveau mot de passe :</label>
    <input type="password" id="confirm_password" name="confirm_password" required><br><br>
    <div class="message error"><?php echo $errorMsg; ?></div>
    <div class="message success"><?php echo $successMsg; ?></div>
    <button type="submit">Modifier</button>
</form>


    <footer>
        <p>Library, created by Elyea and Chaïma. All rights reserved.</p>
    </footer>
</body>
</html>
