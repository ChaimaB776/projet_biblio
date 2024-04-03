<?php
// Inclure le fichier de connexion à la base de données
include 'bdd.php';

// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté, sinon le rediriger vers la page de connexion
if (!isset($_SESSION["username"])) {
    header("Location: connexion.php");
    exit();
}

// Traitement pour ajouter un nouveau livre à la bibliothèque personnelle
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addBook"])) {
    // Récupérer les données du formulaire
    $title = $_POST["titre"];
    $author = $_POST["auteur"];

    // Insérer le nouveau livre dans la base de données
    try {
        $stmt = $pdo->prepare("INSERT INTO favoris (users_id, titre, auteur) VALUES (:users_id, :titre, :auteur)");
        $stmt->execute(array(':users_id' => $_SESSION["users_id"], ':titre' => $title, ':auteur' => $author));
        // Rediriger vers la page favoris.php pour rafraîchir la liste des livres
        header("Location: favoris.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur lors de l'ajout du livre : " . $e->getMessage();
    }
}

// Traitement pour supprimer un livre de la bibliothèque personnelle
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteBook"])) {
    // Récupérer l'ID du livre à supprimer
    $bookId = $_POST["bookId"];

    // Supprimer le livre de la base de données
    try {
        $stmt = $pdo->prepare("DELETE FROM favoris WHERE id = :bookId AND users_id = :usersId");
        $stmt->execute(array(':bookId' => $bookId, ':usersId' => $_SESSION["users_id"]));
        // Rediriger vers la page favoris.php pour rafraîchir la liste des livres
        header("Location: favoris.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression du livre : " . $e->getMessage();
    }
}

// Récupérer les livres de la bibliothèque personnelle de l'utilisateur
try {
    $stmt = $pdo->prepare("SELECT * FROM favoris WHERE users_id = :usersId");
    $stmt->execute(array(':usersId' => $_SESSION["users_id"]));
    $favoriteBooks = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des livres favoris : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Favoris</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php"><img src="img/logo.png" alt="Logo de l'entreprise"></a></li>
                <li class="titre"><h1>Librairie</h1></li>
                <?php
                // Vérifier si l'utilisateur est connecté
                if (isset($_SESSION["username"])) {
                    // Afficher le nom de l'utilisateur et un lien de déconnexion
                    echo "<li class='produit'><a href='deconnexion.php' style='color:#4c6be6;'>Déconnexion</a></li>";
                    echo "<li class='produit'><span style='color:#4c6be6;'>Bonjour, " . $_SESSION["username"] . "!</span></li>";
                } else {
                    // Si l'utilisateur n'est pas connecté, afficher un lien de connexion
                    echo "<li class='produit'><a href='connexion.php' style='color:#4c6be6;'>Connexion</a></li>";
                }
                ?>
                <li class="produit"><a href="favoris.php" style="color:#4c6be6;">Favoris</a></li>
            </ul>
        </nav>
    </header>

    <h1>Mes Livres Favoris</h1>

    <!-- Section pour afficher les livres de la bibliothèque personnelle -->
    <section id="favoriteBooks">
        <h2>Votre Bibliothèque Personnelle</h2>
        <?php if (!empty($favoriteBooks)) : ?>
            <ul>
                <?php foreach ($favoriteBooks as $book) : ?>
                    <li>
                        <?php echo $book['titre']; ?> par <?php echo $book['auteur']; ?>
                        <form action="" method="post">
                            <input type="hidden" name="bookId" value="<?php echo $book['id']; ?>">
                            <button type="submit" name="deleteBook">Supprimer</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>Aucun livre dans votre bibliothèque personnelle pour le moment.</p>
        <?php endif; ?>
    </section>

    <!-- Formulaire pour ajouter un nouveau livre
     à la bibliothèque personnelle/ a enlever si le bouton marche -->
    <section id="addBookForm">
        <h2>Ajouter un Nouveau Livre</h2>
        <form action="" method="post">
            <label for="titre">Titre :</label>
            <input type="text" id="titre" name="titre" required>
            <label for="auteur">Auteur :</label>
            <input type="text" id="auteur" name="auteur" required>
            <button type="submit" name="addBook">Ajouter</button>
        </form>
    </section>

    <footer>
     
    </footer>
</body>
<footer>
        <p>Library, created by Elyea and Chaïma. All rights reserved.</p>
    </footer>
</html>
