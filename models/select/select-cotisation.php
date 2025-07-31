<?php
if (isset($_GET["idCotisation"])) {
    $id = $_GET["idCotisation"];
    $getDataMod = $connexion->prepare("SELECT * FROM cotisation WHERE id=?");
    $getDataMod->execute([$id]);
    $tab = $getDataMod->fetch();
    $TypeModif=$tab["type"];
    $title = "Modifier Une cotisation"; ;
    $btn = "Modifier";
    $url = "../models/updat/up-cotisation-post.php?idCotisation=" . $id;
}
else {
    $btn = "Enregistrer";
    $url = "../models/add/add-Cotisation-post.php";
}

# Selection Des données des membres
$statut=0;
$getType = $connexion->prepare("SELECT * FROM `type_cotisation` WHERE type_cotisation.statut=?;");
$getType->execute([$statut]);
# Selection des touts les colis non encore embarquer
$getData = $connexion->prepare("SELECT `cotisation`.*, type_cotisation.description as TypeDescription FROM `cotisation`,`type_cotisation` WHERE cotisation.type=type_cotisation.id AND cotisation.statut=?;");
$getData->execute([$statut]);
