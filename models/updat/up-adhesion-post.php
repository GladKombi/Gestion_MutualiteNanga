<?php
#inclusion de la page de connexion
include('../../connexion/connexion.php');
# Modification de données d'un Agent
if (isset($_POST["Valider"]) && !empty($_GET["idAdhesion"])) {
    $id = $_GET["idAdhesion"];
    $montant = htmlspecialchars($_POST['montant']);
    $membre = htmlspecialchars($_POST['membre']);;
    #verifier si le poid ne pas alphanumeric
    if (is_numeric($montant)) {
        $InsertData = $connexion->prepare("UPDATE adhesion SET `membre`=?, montant=? WHERE id=?");
        $resultat = $InsertData->execute(array($membre, $montant,  $id));
        if ($resultat == true) {
            $_SESSION['msg'] = "les modifications viens d'etre sauvegardées avec succès!";
            header("location:../../views/adhesion.php");
        } else {
            $_SESSION['msg'] = "The update failled !";
            header("location:../../views/adhesion.php");
        }
    } else {
        $_SESSION['msg'] = "Le montant doit être un nombre valide !";
        header("location:../../views/adhesion.php");
    }
} else {
    header("location:../../views/adhesion.php");
}
