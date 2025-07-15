<?php
include("../../connexion/connexion.php");
if (isset($_POST["Valider"]) && isset($_GET["container"])) {
    $container = $_GET["container"];
    $package = htmlspecialchars($_POST['package']);
    $statut = 0;
    #verifier si le cbm ne pas alphanumeric
    $req = $connexion->prepare("INSERT INTO `loading`(`date`, `colis`, `container`, `statut`) VALUES (now(),?,?,?)");
    $test = $req->execute(array($package, $container, $statut));
    if ($test == true) {
        $_SESSION['msg'] = "Un nouveau colis viens d'etre charger !";
        header("location:../../views/loanding.php?loading");
    } else {
        $_SESSION['msg'] = "Registration faill !";
        header("location:../../views/loanding.php?loading");
    }
} else {
    header("location:../../views/loanding.php");
}
