<?php
// Démarre la session
session_start();

// Inclus le fichier de connexion à la base de données
// Assurez-vous que le chemin est correct pour votre projet
require 'db_connect.php';

// Vérifie si la requête est bien de type POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Récupération et nettoyage des données du formulaire
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
    $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // 2. Validation des données
    if (empty($id) || empty($nom) || empty($prenom) || empty($username)) {
        $_SESSION['msg'] = "Échec de mise à jour : Champs obligatoires manquants.";
        header("location:../../views/dashboard-membre.php");
        exit();
    }

    // 3. Gestion du téléchargement de la photo de profil
    $new_photo_path = null;
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
        $file_name = $_FILES['profile_photo']['name'];
        $file_tmp = $_FILES['profile_photo']['tmp_name'];
        $file_size = $_FILES['profile_photo']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($file_ext, $allowed_exts) && $file_size < 5000000) {
            $new_file_name = uniqid('', true) . '.' . $file_ext;
            $upload_path = '../../img/' . $new_file_name;

            if (move_uploaded_file($file_tmp, $upload_path)) {
                $new_photo_path = $new_file_name;
            } else {
                $_SESSION['msg'] = "Échec du téléchargement de la photo.";
                header("location:../../views/dashboard-membre.php");
                exit();
            }
        } else {
            $_SESSION['msg'] = "Type de fichier ou taille invalide.";
            header("location:../../views/dashboard-membre.php");
            exit();
        }
    }

    // 4. Construction de la requête SQL de manière dynamique
    $sql = "UPDATE membre SET nom = :nom, prenom = :prenom, email = :email";
    $params = [
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':email' => $username,
        ':id' => $id
    ];

    if (!empty($password)) {
        $sql .= ", password = :password";
        $params[':password'] = $password;
    }

    if ($new_photo_path) {
        $sql .= ", photo = :photo";
        $params[':photo'] = $new_photo_path;
    }

    $sql .= " WHERE id = :id";

    // 5. Préparation et exécution de la requête SQL
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        if ($stmt->rowCount() > 0) {
            // Suppression de l'ancienne photo si une nouvelle a été téléchargée
            if ($new_photo_path) {
                $stmt_select = $conn->prepare("SELECT photo FROM membre WHERE id = :id");
                $stmt_select->execute([':id' => $id]);
                $old_photo_row = $stmt_select->fetch(PDO::FETCH_ASSOC);

                if ($old_photo_row && $old_photo_row['photo'] !== 'default.png' && file_exists("../../img/" . $old_photo_row['photo'])) {
                    unlink("../../img/" . $old_photo_row['photo']);
                }
            }

            // Mise à jour des variables de session et redirection
            $_SESSION['nom'] = $nom;
            $_SESSION['prenom'] = $prenom;
            $_SESSION['email'] = $username;
            if ($new_photo_path) {
                $_SESSION['user_photo'] = $new_photo_path;
            }
            $_SESSION['msg'] = "Profil mis à jour avec succès !";
        } else {
            $_SESSION['msg'] = "Aucune modification n'a été faite.";
        }
        header("location:../../views/dashboard-membre.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['msg'] = "Échec de mise à jour : " . $e->getMessage();
        header("location:../../views/dashboard-membre.php");
        exit();
    }
} else {
    // Redirige si la méthode n'est pas POST
    header("Location: ../../index.php");
    exit();
}
