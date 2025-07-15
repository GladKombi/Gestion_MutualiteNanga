<?php
include('../../connexion/connexion.php');

if (isset($_POST['Valider']) && isset($_GET['idTarif'])) {
    $tarif = $_GET['idTarif'];
    $montant = htmlspecialchars($_POST['montant']);
    $statut = 0;
    $getContainer = $connexion->prepare("SELECT container FROM tarif WHERE tarif.id=? ");
    $getContainer->execute([$tarif]);
    if ($mat = $getContainer->fetch()) {
        $container = $mat[0];
    }
    if (is_numeric($montant)) {
        $req = $connexion->prepare("UPDATE `tarif` SET majoration=? WHERE id=?");
        $resultat = $req->execute([$montant,$tarif]);
        #Si oui, la variable resultat va retourée true, donc il y a eu une modification
        if ($resultat == true) {
            $_SESSION['msg'] = "La modification réussi !"; 
            header("location:../../views/tarif-view.php?container=" . $container);
        } else {
            $_SESSION['msg'] = "Echec de la modification !"; 
            header("location:../../views/tarif-view.php?container=" . $container);
        }
    } else {
        $_SESSION['msg'] = "Veillez Vefier les champs Svp !";
        header("location:../../views/tarif-view.php?container=" . $container);
    }
} else {
    //Cette ligne permet de rediriger l'utiliseteur lors qu'il a pas cliquer sur le button qui sert à modifier
    header("location:../../views/charge.php");
}
