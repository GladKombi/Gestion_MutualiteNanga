<?php
if (isset($_GET["idContainer"])) {
    $id = $_GET["idContainer"];
    $getDataMod = $connexion->prepare("SELECT * FROM container WHERE id=?");
    $getDataMod->execute([$id]);
    $tab = $getDataMod->fetch();
    $container = $tab["date"];
    $titre = "Modifier le chargement du " . $container;
    $btn = "Update";
    $url = "../models/updat/up-Container-post.php?idContainer=" . $id;
}
if (isset($_GET["SupCont"])) {
    $idSup = $_GET["SupCont"];
    $getDataSup = $connexion->prepare("SELECT * FROM `container` WHERE container.id=?");
    $getDataSup->execute([$idSup]);
    $tab = $getDataSup->fetch();
    $ContaiDat = $tab['date'];    
    $url = "../models/delete/del-Container.php?idContainer=" . $idSup;
} else {
    if (!isset($_GET["idContainer"])) {
        $titre = "Nouveau Convois";
        $btn = "Enregistrer";
        $url = "../models/add/add-container-post.php";
    }
}

# Selection Des données des membres
$statut = 0;
$getMember = $connexion->prepare("SELECT * FROM `membre` WHERE membre.statut=? ORDER BY `membre`.`id` DESC;");
$getMember->execute([$statut]);
# Selection des touts les colis non encore embarquer
$getData = $connexion->prepare("SELECT * FROM `container` WHERE container.statut=?;");
$getData->execute([$statut]);
