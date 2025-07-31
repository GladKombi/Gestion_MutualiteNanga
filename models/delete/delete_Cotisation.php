<?php
# Se connecter à la BD
include '../../connexion/connexion.php';
#suppression
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $supprimer = 1;
    $req = $connexion->prepare("UPDATE `cotisation` SET statut=? WHERE id=?");
    $resultat = $req->execute([$supprimer, $id]);
    if ($resultat == true) {
        $_SESSION['msg'] = "La suppression d'une cotisation a été effectuer avec succès!";
        header('location:../../views/cotisation.php');
    }else{
         $_SESSION['msg'] = "Echec suppression ";
        header('location:../../views/cotisation.php');
    }
} else {
    header('location:../../views/cotisation.php');
}