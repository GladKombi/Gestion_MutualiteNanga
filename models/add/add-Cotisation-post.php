<?php
# Cette ligne permet d'étabir la connexion à la base de données
include('../../connexion/connexion.php');
if (isset($_POST['Valider'])) {
    $description = htmlspecialchars($_POST['description']);
    $montant = htmlspecialchars($_POST['montant']);
    $type = htmlspecialchars($_POST['type']);
    $statut = 0;
    if (is_numeric($montant)) {
        # Insertion data from database
        $req = $connexion->prepare("INSERT INTO `cotisation`(`date`, `description`, `type`, `montant`, `statut`)  VALUES (now(),?,?,?,?)");
        $resultat = $req->execute([$description, $type, $montant, $statut]);
        #Si oui, la variable resultat va retourée true, donc il y a eu un enregistrement
        if ($resultat == true) {
            $_SESSION['msg'] = "Une nouvelle Cotisation viens d'etre ajouter avec succès!";
            header("location:../../views/cotisation.php");
        } else {
            $_SESSION['msg'] = "Echec d'enreigistrement";
            header("location:../../views/cotisation.php");
        }
    } else {
        $_SESSION['msg'] = "Veillez Vefier les champs Svp !";
        header("location:../../views/cotisation.php");
    }
} else {
    header("location:../../views/cotisation.php");
}
