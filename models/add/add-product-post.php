<?php
// Appel de la connexion
include_once '../../connexion/connexion.php';
if (isset($_POST['valider']) && !empty($_GET["SaleId"])) {
    $idSale = $_GET['SaleId'];
    $Prod = htmlspecialchars($_POST['Produit']);
    $Quantite = htmlspecialchars($_POST['quantity']);
    $price = htmlspecialchars($_POST['price']);

    //Recuperation de la quantité totale de la commande de cette utilisateur
    $getTotQuantity = $connexion->prepare("SELECT `participants`.`quantite`, `command`.`prix` FROM `participants`,`command` WHERE participants.commad=command.id AND participants.id=?");
    $getTotQuantity->execute(array($Prod));
    if ($tab = $getTotQuantity->fetch()) {
        $commandQuant = $tab['quantite'];
        $CommPrice = $tab['prix'];
    } else {
        $commandQuant = 0;
    }
    /**
     * Cette requette retourne la quantité déjà Vendue
     */
    $getQuantV = $connexion->prepare("SELECT SUM(quantity) as stockV FROM panier WHERE product=?");
    $getQuantV->execute(array($Prod));
    if ($table = $getQuantV->fetch()) {
        $stockVendu = $table['stockV'];
    } else {
        $stockVendu = 0;
    }
    $QuantResta = $commandQuant - $stockVendu;
    // echo $QuantResta;
    //Ici on verifie si quantité qu'on veux attribuer n'est pas supperieur à celle de la commande                  
    if ($Quantite > $QuantResta) {
        $_SESSION['msg'] = "Please enter a valid quantity !";
        header("location:../../views/ventes.php?saleId=$idSale");
    } else {
        if ($price < $CommPrice) {
            $_SESSION['msg'] = "Please Verifier the price of the selected product !";
            header("location:../../views/ventes.php?saleId=$idSale");
        } else {
            $statut = 0;
            $req = $connexion->prepare("INSERT INTO `panier`(`vente`, `product`, `quantity`, `price`, `statut`) VALUES  (?,?,?,?,?)");
            $req->execute(array($idSale, $Prod, $Quantite, $price, $statut));
            if ($req) {
                $_SESSION['msg'] = "A new addition to the order has just been made !";
                header("location:../../views/ventes.php?saleId=$idSale");
            }
        }
    }
} else {
    header("location:../../views/ventes.php");
}
