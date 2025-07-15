<?php
include_once '../../connexion/connexion.php';
// Modifier les données du panier
if (isset($_POST['modifier']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $Description = htmlspecialchars($_POST['Description']);
    $Quantite = htmlspecialchars($_POST['Quantite']);
    $entree = htmlspecialchars($_POST['entree']);
    /**
     * Cette requette retourne la quantité et le prix de produit qui est en stock
     */
    $requet = $connexion->prepare("SELECT quantite FROM panier WHERE id=?");
    $requet->execute(array($id));
    if ($dupanier = $requet->fetch()) {
        $Qtepanier = $dupanier['quantite'];
     
    } else {
        $Qtepanier = 0;
    }

    $req = $connexion->prepare("SELECT quantite, prix FROM `entree` WHERE id=?"); //Recuperation de la quantité et du prix
    $req->execute(array($entree));
    if ($tab = $req->fetch()) {
        $QuantiteEnre = $tab['quantite'];
        $prix = $tab['prix'];
    } else {
        $QuantiteEnre = 0;
        $prix = 0;
    }
    $requete = $connexion->prepare("SELECT SUM(quantite) as stock FROM panier WHERE entree=?");
    $requete->execute(array($entree));
    if ($table = $requete->fetch()) {
        $stockVendu = $table['stock'];
    } else {
        $stockVendu = 0;
    }
    $stockResta = ($QuantiteEnre - $stockVendu)+$Qtepanier;
    //Ici on verifie si quantité qu'on a besion de commandée est supperieur à ce qui est en stok                  
    if ($Quantite > $stockResta) {
        $_SESSION['msge'] = "Nous pouvons servir la quantité que vous avez saisi. Le stock est insufisant !";
        header("location:../../views/commande.php?idcom=$id");
    } else {
        $idcom= $_GET['idcom'];
        $idpanier=0;
        $req = $connexion->prepare("UPDATE panier set description=?, quantite=?, prix=?, entree=? where id=?");
        $resultat = $req->execute(array($Description, $Quantite, $prix, $entree, $id));
        if ($resultat == true) {
            header("location:../../views/commande.php?idcom=$idcom&idpanier=$idpanier");
           
        } else {
            $_SESSION['msg'] = "Echec de la modification";
            header('location:../../views/commande.php');
        }
    }
}
if(isset($_POST['Modifiercoom']))
{
    $idcom= $_GET['idcom'];
    $client=htmlspecialchars($_POST['client']);
    $req=$connexion->prepare("UPDATE  commande set client=? where id=$idcom");
    $resultat=$req->execute(array($client));
    if ($resultat == true) {
        $reqe=$connexion->prepare("SELECT id from panier WHERE commande=? limit 1");
        $reqe->execute(array($idcom));
        $panier=$reqe->fetch();
        $idpanier=$panier['id'];
        $_SESSION['msg'] = "Modification reussie";
        header("location:../../views/commande.php?idcom=$idcom&idpanier=$idpanier");
    } else {
        $_SESSION['msg'] = "Echec de la modification";
        header('location:../../views/commande.php');
    }

}