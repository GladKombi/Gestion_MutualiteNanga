<?php
# Se connecter à la BD
include '../../connexion/connexion.php';
#suppression
if (isset($_GET['idContainer']) && !empty($_GET['idContainer'])) {
    $id = $_GET['idContainer'];
    $supprimer = 1;
    $req = $connexion->prepare("UPDATE `container` SET statut=? WHERE id=?");
    $resultat = $req->execute([$supprimer, $id]);
    if ($resultat == true) {
        $_SESSION['msg'] = "La suppression du container a été effectuer avec succès!";
        header('location:../../views/container.php');
    }else{
         $_SESSION['msg'] = "Echec suppression ";
        header('location:../../views/container.php');
    }
} else {
    header('location:../../views/container.php');
}
