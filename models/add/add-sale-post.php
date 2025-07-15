<?php
#inclusion de la page de connexion
include('../../connexion/connexion.php');
# Add a sale
if (isset($_POST['valider'])) {
    $Client = htmlspecialchars($_POST['Client']);
    $statut = 0;
    if (!empty($Client)) {
        $req = $connexion->prepare("INSERT INTO `sales`(`date`, `client`, `statut`) VALUES (now(),?,?)");
        $resultat = $req->execute(array($Client,$statut));
        $id = $connexion->lastInsertId();
        if ($resultat == true) {
            $_SESSION['msg'] = " The sale has been registre then shop now !";
            header("location:../../views/ventes.php?saleId=$id");
        }else {
            $_SESSION['msg'] = "Failed to register !";
            header("location:../../views/ventes.php?newSale");
        }
    } else {
        $_SESSION['msg'] = "Please enter client name ";
        header("location:../../views/ventes.php?newSale");
    }
} else {
    header("location:../../views/ventes.php");
}
