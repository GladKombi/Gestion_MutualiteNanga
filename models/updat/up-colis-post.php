<?php
#inclusion de la page de connexion
include('../../connexion/connexion.php');
# Modification de données d'un Agent
if (isset($_POST["Valider"]) && !empty($_GET["idColis"])) {
    $id = $_GET["idColis"];
    $description = htmlspecialchars($_POST['description']);
    $member = htmlspecialchars($_POST['member']);
    $poid = htmlspecialchars($_POST['poid']);
    #verifier si le poid ne pas alphanumeric
    if (is_numeric($poid)) {
        $InsertData = $connexion->prepare("UPDATE colis SET `description`=?, member=?, poid=? WHERE id=?");
        $resultat = $InsertData->execute(array($description, $member, $poid, $id));
        if ($resultat == true) {
            $_SESSION['msg'] = "Ce colis viens d'etre modifier avec succès!";
            header("location:../../views/colis.php");
        } else {
            $_SESSION['msg'] = "The update failled !";
            header("location:../../views/colis.php");
        }
    } else {
        $_SESSION['msg'] = "Le poid du colis ne doit pas containir des caractères alpha numerique";
        header("location:../../views/colis.php");
    }
} else {
    header("location:../../views/colis.php");
}
