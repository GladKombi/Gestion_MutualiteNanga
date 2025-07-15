<?php
if (isset($_GET['container'])) {
    $container = $_GET["container"];
    $getLastContai = $connexion->prepare("SELECT * FROM `container` WHERE container.id=? ");
    $getLastContai->execute([$container]);
    if ($mat = $getLastContai->fetch()) {
        $containerId = $mat['id'];
        $LastestContainer = $mat['id'] . " - " . $mat['date'] . " " . $mat['chauffeur'];
    }
    $title = "Definir Tarif pour le containeur " . $LastestContainer;
    $btn = "Enregistrer";
    $action = "../models/add/add-tarif-post.php?idContainer=" . $containerId;
    $statut = 0;
    # Selection des charge du containeur
    $getCharge = $connexion->prepare("SELECT SUM(charge.montant) as totalCharge FROM `charge` WHERE charge.container=?;");
    $getCharge->execute([$container]);
    if ($charge = $getCharge->fetch()) {
        $totalCharge = $charge['totalCharge'];
    } else {
        $totalCharge = 0;
    }
}
elseif (isset($_GET['idTarif'])) {
    $container = $_GET["idTarif"];
    # Selection de la charge à modifier
    $getTarif = $connexion->prepare("SELECT * FROM `tarif` WHERE tarif.container=? ");
    $getTarif->execute([$container]);
    $tab = $getTarif->fetch();
    $tarif = $tab["id"];
    $majoration = $tab["majoration"];
    $action = "../models/updat/up-tarif-post.php?idTarif=" . $tarif;
    $btn = "Modifier";
     $getLastContai = $connexion->prepare("SELECT * FROM `container` WHERE container.id=? ");
    $getLastContai->execute([$container]);
    if ($mat = $getLastContai->fetch()) {
        $containerId = $mat['id'];
        $LastestContainer = $mat['id'] . " - " . $mat['date'] . " " . $mat['chauffeur'];
    }
    $title = "Modifier Tarif pour le containeur " . $LastestContainer;
    # Selection des charge du containeur
    $getCharge = $connexion->prepare("SELECT SUM(charge.montant) as totalCharge FROM `charge` WHERE charge.container=?;");
    $getCharge->execute([$container]);
    if ($charge = $getCharge->fetch()) {
        $totalCharge = $charge['totalCharge'];
    } else {
        $totalCharge = 0;
    }
} elseif (isset($_GET["SupCharge"])) {
    $charge = $_GET['SupCharge'];
    $getContainer = $connexion->prepare("SELECT container FROM charge WHERE charge.id=? ");
    $getContainer->execute([$charge]);
    if ($mat = $getContainer->fetch()) {
        $container = $mat[0];
    }
    $url = "../models/delete/del-charge.php?idCharge=" . $charge;
    $btn = "Supprimer";
    $title = "Supression";
} elseif (isset($_GET["Fixer"])) {
    $container = $_GET["Fixer"];
    $getLastContai = $connexion->prepare("SELECT * FROM `container` WHERE container.id=? ");
    $getLastContai->execute([$container]);
    if ($mat = $getLastContai->fetch()) {
        $containerId = $mat['id'];
        $LastestContainer = $mat['id'] . " - " . $mat['date'] . " " . $mat['chauffeur'];
    }
    $title = "Definir Tarif pour le containeur " . $LastestContainer;
    $btn = "Fixer le tarif";
    $url = "tarif.php?container=" . $containerId;
} else {
    $title = "Fixer tarif";
    $btn = "Enregistrer";
    $url = "../models/add/add-tarif-post.php";
}
# Selection des touts les Chargements deja embarquer
$statut = 0;
$getData = $connexion->prepare("SELECT container.*,loading.container FROM `container`, `loading` WHERE loading.container=container.id AND loading.statut=? AND loading.container NOT IN(SELECT tarif.container FROM tarif WHERE tarif.statut=0);");
$getData->execute([$statut]);
