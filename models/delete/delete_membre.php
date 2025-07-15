<?php
# Se connecter à la BD
include '../../connexion/connexion.php';
#suppression
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $supprimer = 1;
    $req = $connexion->prepare("UPDATE `membre` SET statut=? WHERE id=?");
    $resultat = $req->execute([$supprimer, $id]);
    if ($resultat == true) {
        $_SESSION['msg'] = "La suppression du membre a été effectuer avec succès!";
        header('location:../../views/membre.php');
    }else{
         $_SESSION['msg'] = "Echec suppression ";
        header('location:../../views/membre.php');
    }
} else {
    header('location:../../views/membre.php');
}