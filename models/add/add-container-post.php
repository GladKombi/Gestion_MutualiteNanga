<?php
# Cette ligne permet d'étabir la connexion à la base de données
include('../../connexion/connexion.php');
if (isset($_POST['Valider'])) {
    $chauffeur = htmlspecialchars($_POST['chauffeur']);
    $plaque = htmlspecialchars($_POST['plaque']);
    $statut = 0;
    # Insertion data from database
    $req = $connexion->prepare("INSERT INTO `container`(`date`, `chauffeur`, `numPlaque`, `statut`) VALUES  (Now(),?,?,?)");
    $resultat = $req->execute([$chauffeur,$plaque, $statut]);
    #Si oui, la variable resultat va retourée true, donc il y a eu un enregistrement
    if ($resultat == true) {
        $_SESSION['msg'] = "Un nouveau chargement viens d'etre ajouter avec succès !";
        header("location:../../views/loanding.php?loading");
    } else {
        $_SESSION['msg'] = "Echec d'enreigistrement";
        header("location:../../views/container.php");
    }
} else {
    header("location:../../views/container.php");
}
