<?php
# Cette ligne permet d'étabir la connexion à la base de données
include('../../connexion/connexion.php');
if (isset($_POST['Valider']) && isset($_GET['idContainer'])) {
    $container = $_GET['idContainer'];
    $description = htmlspecialchars($_POST['description']);
    $montant = htmlspecialchars($_POST['montant']);
    $statut = 0;
    if (is_numeric($montant)) {
        # Insertion data from database
        $req = $connexion->prepare("INSERT INTO `charge`(`date`, `description`, `montant`, `container`, `statut`)  VALUES (now(),?,?,?,?)");
        $resultat = $req->execute([$description, $montant, $container, $statut]);
        #Si oui, la variable resultat va retourée true, donc il y a eu un enregistrement
        if ($resultat == true) {
            $_SESSION['msg'] = "Une nouvelle Charge viens d'etre ajouter !";
            header("location:../../views/charge.php?container=" . $container);
        } else {
            $_SESSION['msg'] = "Echec d'enreigistrement";
            header("location:../../views/charge.php?container=" . $container);
        }
    } else {
        $_SESSION['msg'] = "Veillez Vefier les champs Svp !";
        header("location:../../views/charge.php?container=" . $container);
    }
} else {
    header("location:../../views/charge.php");
}
