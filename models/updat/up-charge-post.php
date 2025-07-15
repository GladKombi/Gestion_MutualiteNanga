<?php
include('../../connexion/connexion.php');

if (isset($_POST['Valider']) && isset($_GET['idCharge'])) {
    $charge = $_GET['idCharge'];
    $description = htmlspecialchars($_POST['description']);
    $montant = htmlspecialchars($_POST['montant']);
    $statut = 0;
    $getContainer = $connexion->prepare("SELECT container FROM charge WHERE charge.id=? ");
    $getContainer->execute([$charge]);
    if ($mat = $getContainer->fetch()) {
        $container = $mat[0];
    }
    if (is_numeric($montant)) {
        $req = $connexion->prepare("UPDATE `charge` SET description=?, montant=?  WHERE id=?");
        $resultat = $req->execute([$description,$montant,$charge]);
        #Si oui, la variable resultat va retourée true, donc il y a eu une modification
        if ($resultat == true) {
            $_SESSION['msg'] = "La modification réussi !"; 
            header("location:../../views/charge.php?container=" . $container);
        } else {
            $_SESSION['msg'] = "Echec de la modification !"; 
            header("location:../../views/charge.php?container=" . $container);
        }
    } else {
        $_SESSION['msg'] = "Veillez Vefier les champs Svp !";
        header("location:../../views/charge.php?container=" . $container);
    }
} else {
    //Cette ligne permet de rediriger l'utiliseteur lors qu'il a pas cliquer sur le button qui sert à modifier
    header("location:../../views/charge.php");
}
