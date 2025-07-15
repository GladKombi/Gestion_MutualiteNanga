<?php 
    include '../../connexion/connexion.php';
    //Supprimer dans le panier 
    if(isset($_GET['idpanier']) && !empty($_GET['idpanier'])){
        $id=$_GET['idpanier'];
        $supprimer=1;
        // requette permettant de supprimer les info de la ligne selectionnée dans la base des données
        $req=$connexion->prepare("UPDATE panier SET supprimer=? WHERE id=?");
        $resultat=$req->execute(array($supprimer,$id));   
        if($resultat==true){
            $_SESSION['msg']="suppression reussie";
            header('Location:../../views/commande.php');
        }else{
            $_SESSION['msg']="Echec de la suppression";
            header('location:../../views/commande.php');
        }
    }
    if(isset($_GET['idcom']) && !empty($_GET['idcom'])){
        $id=$_GET['idcom'];
        $supprimer=1;
        // requette permettant de supprimer les info de la ligne selectionnée dans la base des données
        $req=$connexion->prepare("UPDATE commande SET supprimer=? WHERE id=?");
        $resultat=$req->execute(array($supprimer,$id));   
        if($resultat==true){
            $_SESSION['msg']="suppression reussie";
            header('Location:../../views/commande.php');
        }else{
            $_SESSION['msg']="Echec de la suppression";
            header('location:../../views/commande.php');
        }
    }else{
        header('location:../../views/commande.php');
    }