<?php
include("../../connexion/connexion.php");
if (isset($_POST["Valider"])) {
    $description = htmlspecialchars($_POST['description']);
    $member = htmlspecialchars($_POST['member']);
    $poid = htmlspecialchars($_POST['poid']);
    $statut = 0;
    #verifier si le$poid ne pas alphanumeric
    if (is_numeric($poid)) {
        $req = $connexion->prepare("INSERT INTO `colis`(`date`, `description`, `member`, `poid`, `statut`) VALUES (now(),?,?,?,?)");
        $test = $req->execute(array($description, $member, $poid, $statut));
        if ($test == true) {
            $_SESSION['msg'] = "un colis vient d'etre enregistré avec succès!";
            header("location:../../views/colis.php");
        } else {
            $_SESSION['msg'] = "Registration faill !";
            header("location:../../views/colis.php");
        }
    } else {
        $_SESSION['msg'] = "The package CMB's should not contain string caraters";
        header("location:../../views/colis.php");
    }
} else {
    header("location:../../views/colis.php");
}
