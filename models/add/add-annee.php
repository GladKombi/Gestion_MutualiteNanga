<?php
#script d'insertion des boutiques dans la base de données
include('../../connexion/connexion.php');
if (isset($_GET['btn'])) {

    $date1 = date('Y');
    $date2 = $date1 + 1;

    // Récupérer la dernière ligne insérée en utilisant la colonne auto-incrémentée 'id'
    $query = "SELECT * FROM annees ORDER BY id DESC LIMIT 1";
    $stmt = $connexion->prepare($query);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $libelle2 = $data['libelle2'] + 1;

            $query1 = "INSERT INTO annees(libelle, libelle2, `statut`) VALUES (?, ?, ?)";
            $smt = $connexion->prepare($query1);
            $smt->execute([$data['libelle2'], $libelle2, 0]);
            if ($smt == true) {
                $_SESSION['msg'] = "Une nouvelle année Viens d'etre Ajouter !";
                header("location:../../views/adhesion.php");
            }
        }
    } else {
        $query1 = "INSERT INTO annees(libelle, libelle2, `statut`) VALUES (?, ?, ?)";
        $smt = $connexion->prepare($query1);
        $smt->execute([$date1, $date2, 0]);
        if ($smt == true) {
            $_SESSION['msg'] = "Une nouvelle année Viens d'etre Ajouter !";
            header("location:../../views/adhesion.php");
        }
    }

    header("Location:../../views/annees.php");
}
