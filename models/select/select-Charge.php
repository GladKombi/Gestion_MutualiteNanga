<?php
if (isset($_GET['container'])) {
    $container = $_GET["container"];
    $getLastContai = $connexion->prepare("SELECT * FROM `container` WHERE container.id=? ");
    $getLastContai->execute([$container]);
    if ($mat = $getLastContai->fetch()) {
        $containerId = $mat['id'];
        $LastestContainer = $mat['id'] . " - " . $mat['date'] . " " . $mat['chauffeur'];
    }
    $title = "AJouter une charge";
    $btn = "Enregistrer";
    $url = "../models/add/add-charge-post.php?idContainer=" . $containerId;
    $statut=0;
    # Selection des charge du containeur
    $getCharge = $connexion->prepare("SELECT * FROM `charge` WHERE charge.container=? and charge.statut=? ");
    $getCharge->execute([$container,$statut]);
}
if (isset($_GET['container']) && isset($_GET['idcharge'])) {
    $charge = $_GET['idcharge'];
    $container = $_GET["container"];
    # Selection de la charge à modifier
    $getChargeMod = $connexion->prepare("SELECT * FROM `charge` WHERE charge.id=? ");
    $getChargeMod->execute([$charge]);
    $tab = $getChargeMod->fetch();
    $url = "../models/updat/up-charge-post.php?idCharge=" . $charge;
    $btn = "Modifier";
    $title = "Modifier une charge";
}
elseif (isset($_GET["SupCharge"])) {
    $charge = $_GET['SupCharge'];
    $getContainer = $connexion->prepare("SELECT container FROM charge WHERE charge.id=? ");
    $getContainer->execute([$charge]);
    if ($mat = $getContainer->fetch()) {
        $container = $mat[0];
    }
    $url = "../models/delete/del-charge.php?idCharge=" . $charge;
    $btn = "Supprimer";
    $title = "Supression";
}
# Selection des touts les Chargements deja embarquer
$statut = 0;
$getData = $connexion->prepare("SELECT container.*,loading.container FROM `container`, `loading` WHERE loading.container=container.id AND loading.statut=?;");
$getData->execute([$statut]);
