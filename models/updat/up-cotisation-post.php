<?php
include('../../connexion/connexion.php');

if (isset($_POST['Valider']) && isset($_GET['idCotisation'])) {
    $id= $_GET['idCotisation'];
    $description = htmlspecialchars($_POST['description']);
    $montant = htmlspecialchars($_POST['montant']);
    $type = htmlspecialchars($_POST['type']);
    $statut = 0;   
    if (is_numeric($montant)) {
        $req = $connexion->prepare("UPDATE `cotisation` SET `description`=?, montant=?, `type`=?  WHERE id=?");
        $resultat = $req->execute([$description,$montant, $type, $id]);
        #Si oui, la variable resultat va retourée true, donc il y a eu une modification
        if ($resultat == true) {
            $_SESSION['msg'] = "La modification réussi !"; 
            header("location:../../views/cotisation.php");
        } else {
            $_SESSION['msg'] = "Echec de la modification !"; 
            header("location:../../views/cotisation.php");
        }
    } else {
        $_SESSION['msg'] = "Veillez Vefier les champs Svp !";
        header("location:../../views/cotisation.php");
    }
} else {
    //Cette ligne permet de rediriger l'utiliseteur lors qu'il a pas cliquer sur le button qui sert à modifier
    header("location:../../views/cotisation.php");
}
