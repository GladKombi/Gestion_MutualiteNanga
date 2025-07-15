<?php
include_once '../../connexion/connexion.php';
# Mark a command as avalaible
if (isset($_GET['idCom'])) {
    $id = $_GET['idCom'];
    $etat = 1;
    $req = $connexion->prepare("UPDATE command set Etat=? where id=?");
    $resultat = $req->execute(array($etat, $id));
    if ($resultat == true) {
        $_SESSION['msg'] = "A new stock is now avalaible";
        header("location:../../views/command.php");
    } else {
        $_SESSION['msg'] = "Operation failed";
        header('location:../../views/command.php');
    }
} else {
    header('location:../../views/command.php');
}
