<?php
include("../../connexion/connexion.php");
if (isset($_POST["Valider"]) && isset($_GET["container"])) {
    $container = $_GET["container"];
    $package = htmlspecialchars($_POST['package']);
    $statut = 0;
    #verifier si le cbm ne pas alphanumeric
    $req = $connexion->prepare("INSERT INTO `dechargement`(`date`, `colis`, `container`, `statut`) VALUES (now(),?,?,?)");
    $test = $req->execute(array($package, $container, $statut));
    if ($test == true) {
        $_SESSION['msg'] = "Operation de déchargement viens d'etre enregistrer avec succès !";
        header("location:../../views/dechargement.php?container=" . $container);
    } else {
        $_SESSION['msg'] = "Echec d'enregistrement!";
        header("location:../../views/dechargement.php?container=" . $container);
    }
} else {
    header("location:../../views/dechargement.php?container=" . $container);
}
