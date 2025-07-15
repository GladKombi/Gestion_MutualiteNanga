<?php
# Se connecter à la BD
include '../../connexion/connexion.php';
#suppression
if (isset($_GET['idSupcat']) && !empty($_GET['idSupcat'])) {
    $id = $_GET['idSupcat'];
    $supprimer = 1;
    $req = $connexion->prepare("UPDATE `categorie` SET statut=? WHERE id=?");
    $resultat = $req->execute([$supprimer, $id]);
    if ($resultat == true) {
        $_SESSION['msg'] = "La suppression de la catégorie a reussie";
        header('location:../../views/categorie.php');
    }else{
         $_SESSION['msg'] = "Echec suppression de la catégorie";
        header('location:../../views/categorie.php');
    }
} else {
    header('location:../../views/categorie.php');
}
