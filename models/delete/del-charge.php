<?php
# Se connecter à la BD
include '../../connexion/connexion.php';
#suppression
if (isset($_GET['idCharge']) && !empty($_GET['idCharge'])) {
    $id = $_GET['idCharge'];
    $supprimer = 1;
    $getContainer = $connexion->prepare("SELECT container FROM charge WHERE charge.id=? ");
    $getContainer->execute([$id]);
    if ($mat = $getContainer->fetch()) {
        $container = $mat[0];
    }
    $req = $connexion->prepare("UPDATE `charge` SET statut=? WHERE id=?");
    $resultat = $req->execute([$supprimer, $id]);
    if ($resultat == true) {
        $_SESSION['msg'] = "Suppression de charge effectué";
       header("location:../../views/charge.php?container=" . $container);
    }else{
         $_SESSION['msg'] = "Echec suppression de la catégorie";
       header("location:../../views/charge.php?container=" . $container);
    }
} else {
   header("location:../../views/charge.php?container=" . $container);
}