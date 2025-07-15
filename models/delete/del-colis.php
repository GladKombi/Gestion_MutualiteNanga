<?php
# Se connecter à la BD
include '../../connexion/connexion.php';
#suppression
if (isset($_GET['idSupColis']) && !empty($_GET['idSupColis'])) {
    $id = $_GET['idSupColis'];
    $supprimer = 1;
    $req = $connexion->prepare("UPDATE `colis` SET statut=? WHERE id=?");
    $resultat = $req->execute([$supprimer, $id]);
    if ($resultat == true) {
        $_SESSION['msg'] = "La suppression du colis a été effectuer avec succès!";
        header('location:../../views/colis.php');
    }else{
         $_SESSION['msg'] = "Echec suppression de la catégorie";
        header('location:../../views/colis.php');
    }
} else {
    header('location:../../views/colis.php');
}
