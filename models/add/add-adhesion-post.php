<?php
// Appel de la connexion
include_once '../../connexion/connexion.php';
// Verification de la session
if (isset($_POST['Valider'])) {
    $montant = htmlspecialchars($_POST['montant']);
    $membre = htmlspecialchars($_POST['membre']);
    $statut = 0;
    if (is_numeric($montant)) {
        //requette permettant d'inserer une adhesion dans la base des données
        $req = $connexion->prepare("INSERT INTO `adhesion`(`date`, `membre`, `montant`, `statut`) VALUES (now(),?,?,?)");
        $resultat = $req->execute(array($membre, $montant, $statut));
        $id = $connexion->lastInsertId();
        if ($resultat == true) {
            $Updatemembre = $connexion->prepare("UPDATE `membre` SET `approbation`=1 WHERE id=?");
            $Updatemembre->execute([$membre]);            
            $_SESSION['msg'] = " Une adhesion viens d'être enregistrer avec succes !";
            header("location:../../views/adhesion.php");
        } else {
            $_SESSION['msg'] = "Une erreur s'est produite lors de l'enregistrement de l'adhesion !";
            header("location:../../views/adhesion.php");
        }
    } else {
        $_SESSION['msg'] = "Le montant doit être un nombre valide !";
        header("location:../../views/adhesion.php");
    }
} else {
    header("location:../../views/adhesion.php");
}
