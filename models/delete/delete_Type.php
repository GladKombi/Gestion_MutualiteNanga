<?php
# Se connecter à la BD
include '../../connexion/connexion.php';
#suppression
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $supprimer = 1;
    $req = $connexion->prepare("UPDATE `type_cotisation` SET statut=? WHERE id=?");
    $resultat = $req->execute([$supprimer, $id]);
    if ($resultat == true) {
        $_SESSION['msg'] = "La suppression du type de cotisation a été effectuer avec succès!";
        header('location:../../views/typeCotisation.php');
    }else{
         $_SESSION['msg'] = "Echec suppression ";
        header('location:../../views/typeCotisation.php');
    }
} else {
    header('location:../../views/typeCotisation.php');
}