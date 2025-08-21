<?php
include('../connexion/connexion.php');
if (isset($_POST['connect'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $fonction = $_GET['fonction'];
    if ($fonction == 'membre') {
        $req = $connexion->prepare("SELECT * FROM membre  WHERE email=? and pwd=?");
        $req->execute(array($username, $password));
        if ($_identifiant = $req->fetch()) {

            $_SESSION['iduser'] = $_identifiant['id'];
            $_SESSION['fonction'] = $fonction;
            $_SESSION['nom'] = $_identifiant['nom'];
            $_SESSION['postnom'] = $_identifiant['postnom'];
            $_SESSION['prenom'] = $_identifiant['prenom'];
            $_SESSION['email'] = $_identifiant['email'];
            $_SESSION['photo'] = $_identifiant['photo'];
            $_SESSION['adresse'] = $_identifiant['adresse'];
            header("location:../views/dashboard-membre.php");
        } else {
            $_SESSION['msg'] = "username or password incorrect";
            header("location:../index.php");
        }
    } else {
        $req = $connexion->prepare("SELECT * FROM users  WHERE username=? and password=?");
        $req->execute(array($username, $password));
        if ($_identifiant = $req->fetch()) {
            $_SESSION['iduser'] = $_identifiant['id'];
            $_SESSION['fonction'] = $_identifiant['fonction'];
            $_SESSION['nom'] = $_identifiant['nom'];
            $_SESSION['postnom'] = $_identifiant['postnom'];
            $_SESSION['prenom'] = $_identifiant['prenom'];
            header("location:../views/home.php");
        } else {
            $_SESSION['msg'] = "username or password incorrect";
            header("location:../index.php");
        }
    }
}
