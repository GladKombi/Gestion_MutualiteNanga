<?php
# Cette ligne permet d'étabir la connexion à la base de données
include('../../connexion/connexion.php');

if (isset($_POST['Valider']) && isset($_GET['idContainer'])) {
    $container = $_GET['idContainer'];
    $montant = htmlspecialchars($_POST['montant']);
    $statut = 0;
    if (is_numeric($montant)) {
        # Insertion data from database
        $req = $connexion->prepare("INSERT INTO `tarif`(`date`, `container`, `majoration`, `statut`) VALUES (now(),?,?,?)");
        $resultat = $req->execute([ $container, $montant, $statut]);
        if ($resultat == true) {
            $_SESSION['msg'] = "Fixation tariffaire reussi !";
            header("location:../../views/tarif.php");
        } else {
            $_SESSION['msg'] = "Echec d'enreigistrement";
            header("location:../../views/tarif.php");
        }
    } else {
        $_SESSION['msg'] = "Veillez Verifier les champs Svp !";
        header("location:../../views/tarif.php");
    }
} else {
    header("location:../../views/tarif.php");
}
