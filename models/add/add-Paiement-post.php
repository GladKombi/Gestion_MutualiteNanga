<?php
include("../../connexion/connexion.php");
if (isset($_POST["Valider"]) && isset($_GET["container"])) {
    $container = $_GET["container"];
    $package = htmlspecialchars($_POST['package']);
    $montant = htmlspecialchars($_POST['montant']);
    $statut = 0;
    #verifier si le cbm ne pas alphanumeric
    $req = $connexion->prepare("INSERT INTO `paiement`(`date`, `colis`, `container`, `montant`, `statut`)VALUES (now(),?,?,?,?)");
    $test = $req->execute(array($package, $container, $montant, $statut));
    if ($test == true) {
        $_SESSION['msg'] = "Paiement Enregistrer avec success !";
        header("location:../../views/paiement.php?container=" . $container);
    } else {
        $_SESSION['msg'] = "Echec d'enregistrement!";
        header("location:../../views/paiement.php?container=" . $container);
    }
} else {
    header("location:../../views/paiement.php?container=" . $container);
}
