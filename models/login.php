<?php
include('../connexion/connexion.php');
if(isset($_POST['connect']))
{
    $username=htmlspecialchars($_POST['username']);
    $password=htmlspecialchars($_POST['password']);

    // Fetch the user based on the username
    $req=$connexion->prepare("SELECT * FROM `utilisateur` WHERE email=?");
    $req->execute(array($username));
    if($_identifiant = $req->fetch()){
        // Verify the password
        if (password_verify($password, $_identifiant['pwd'])) {
            $_SESSION['msg']="";
            $_SESSION['fonction']= $_identifiant['fonction'];
            $_SESSION['iduser']=$_identifiant['id'];
            $_SESSION['boutique']=$_identifiant['boutique'];
            $_SESSION['image']=$_identifiant['photo'];
            $_SESSION['prenom']=$_identifiant['prenom'];
            $_SESSION['telephone']=$_identifiant['telephone'];
            $_SESSION['genre']=$_identifiant['genre'];
            $_SESSION['adresse']=$_identifiant['adresse'];
            $_SESSION['noms']=$_identifiant['nom'].' '.$_identifiant['postnom'];
            $_SESSION['nom']=$_identifiant['nom'];
            $_SESSION['postnom']=$_identifiant['postnom'];
            $_SESSION['pwd']=$_identifiant['pwd'];
            header("location:../views/index.php");
        } else {
            $_SESSION['msg']="username or password incorrect";
            header("location:../index.php");
        }
    } else {
        $_SESSION['msg']="username or password incorrect";
        header("location:../index.php");
    }
}
?>
