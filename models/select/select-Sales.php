<?php
if (isset($_GET['idVente'])) {
    $id = $_GET['idVente'];
    $getDataMod = $connexion->prepare("SELECT * FROM command WHERE id=?");
    $getDataMod->execute([$id]);
    $tab = $getDataMod->fetch();

    #Ici je specifie le lien lors qu'il s'agit de la modification, 
    $url = "../models/updat/up-utilisateur-post.php?idVente=" . $id;
    $btn = "Modify";
    $title = "Modify a sale";
} else {

    #Ici je specifie le lien lors qu'il s'agit de l'enregistrement
    $url = "../models/add/add-Command-post.php";
    $btn = "Save";
    $title = "Add a new sale";
}
if (isset($_GET["newSale"])) {
    # Add a sale while making order
    $url = "../models/add/add-sale-post.php";
    $title = "The Client first";
} elseif (isset($_GET["saleId"])) {
    # Order making
    $statut = 0;
    $user = 2;
    $SaleId = $_GET["saleId"];
    $url = "../models/add/add-product-post.php?SaleId=" . $SaleId;
    $title = "Shoping";
    # Show product in the select form
    $getProduct = $connexion->prepare("SELECT `participants`.*,`command`.`description`,`command`.`prix` FROM `participants`,`command` WHERE participants.commad=command.id AND participants.user=? AND `participants`.statut=?");
    $getProduct->execute([$user, $statut]);
    # Show product in the table while making order
    $getComProd = $connexion->prepare("SELECT panier.*, command.description FROM panier, command, participants, sales WHERE panier.vente=sales.id AND participants.commad=command.id AND panier.product=participants.id AND sales.id=? AND panier.statut=?");
    $getComProd->execute([$SaleId, $statut]);
}
# Sales Show
$statut = 0;
$getData = $connexion->prepare("SELECT * FROM `sales` WHERE `sales`.statut=?");
$getData->execute([$statut]);
