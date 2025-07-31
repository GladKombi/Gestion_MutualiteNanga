<?php
include("../../connexion/connexion.php");
if (isset($_POST["Valider"])) {
    $membre = htmlspecialchars($_POST['membre']);
    $cotisation = htmlspecialchars($_POST['cotisation']);
    $montant = htmlspecialchars($_POST['montant']);
    $statut = 0;

    $reqq = $connexion->prepare("SELECT cotisation.montant as montantdb FROM cotisation where cotisation.id=?;"); //cotisation.id
    $reqq -> execute(array($cotisation));
    $montantdb = $reqq ->fetch();
    if ($montantdb == true){
        $montant2 = $montantdb['montantdb'];
        if($montant > $montant2) {
            $_SESSION['msg'] = "Vous avez entré un montant supérieur à la dette  ";
            header("location:../../views/paiement.php");
            } 
        else {

    $req = $connexion->prepare("INSERT INTO `paiement`(`date`, `adhesion`, `cotisation`, `montant`, `statut`)VALUES (now(),?,?,?,?)");
    $test = $req->execute(array($membre, $cotisation,  $montant, $statut));
    if ($test == true) {
        $_SESSION['msg'] = "Paiement Enregistrer avec success !";
        header("location:../../views/paiement.php");
    } else {
        $_SESSION['msg'] = "Echec d'enregistrement!";
        header("location:../../views/paiement.php");
    }
        
    }

}
}
 else {
    header("location:../../views/paiement.php");
}
