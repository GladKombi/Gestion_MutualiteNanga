<?php
#inclusion de la page de connexion
include('../../connexion/connexion.php');
# Modification de données d'un Agent
if (isset($_POST["Valider"]) && !empty($_GET["idContainer"])) {
    $id = $_GET["idContainer"];
    $chauffeur = htmlspecialchars($_POST['chauffeur']);
    $plaque = htmlspecialchars($_POST['plaque']);

    $InsertData = $connexion->prepare("UPDATE container SET chauffeur=?, numPlaque=? WHERE id=?");
    $resultat = $InsertData->execute(array($chauffeur, $plaque, $id));
    if ($resultat == true) {
        $_SESSION['msg'] = "Ce container viens d'etre modifier avec succès!";
        header("location:../../views/container.php");
    } else {
        $_SESSION['msg'] = "The update failled !";
        header("location:../../views/container.php");
    }
} else {
    header("location:../../views/container.php");
}
