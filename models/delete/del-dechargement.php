<?php
# Se connecter à la BD
include '../../connexion/connexion.php';
#suppression
if (isset($_GET['idDecharg']) && !empty($_GET['idDecharg'])) {
    $id = $_GET['idDecharg'];
    $supprimer = 1;
    $getContainer = $connexion->prepare("SELECT container FROM dechargement WHERE dechargement.id=? ");
    $getContainer->execute([$id]);
    if ($mat = $getContainer->fetch()) {
        $container = $mat[0];
    }
    $req = $connexion->prepare("UPDATE `dechargement` SET statut=? WHERE id=?");
    $resultat = $req->execute([$supprimer, $id]);
    if ($resultat == true) {
        $_SESSION['msg'] = "Suppression de dechargement effectué";
       header("location:../../views/dechargement.php?container=" . $container);
    }else{
         $_SESSION['msg'] = "Echec suppression de la catégorie";
       header("location:../../views/dechargement.php?container=" . $container);
    }
} else {
   header("location:../../views/dechargement.php?container=" . $container);
}