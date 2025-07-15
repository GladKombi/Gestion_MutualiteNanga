<?php
if(isset($_GET['container'])) {
    $container = $_GET["container"];
    # Selection des charge du containeur
    $getCharge = $connexion->prepare("SELECT SUM(charge.montant) as totalCharge FROM `charge` WHERE charge.container=?;");
    $getCharge->execute([$container]);
    if ($charge = $getCharge->fetch()) {
        $totalCharge = $charge['totalCharge'];
    } else {
        $totalCharge = 0;
    }
    # Detail du containeur
    $getLastContai = $connexion->prepare("SELECT * FROM `container` WHERE container.id=? ");
    $getLastContai->execute([$container]);
    if ($mat = $getLastContai->fetch()) {
        $containerId = $mat['id'];
        $LastestContainer = $mat['id'] . " - " . $mat['date'] . " " . $mat['chauffeur'];
    }
    # Selection de la majoration
    $getTarif = $connexion->prepare("SELECT * FROM `tarif` WHERE tarif.container=? AND tarif.statut=0;");
    $getTarif->execute([$container]);
    if ($tarif = $getTarif->fetch()) {
        $majoration = $tarif['majoration'];
    } else {
        $majoration = 0;
    }
    # Selection du poid total des colis dans le containeur
    $getPoid = $connexion->prepare("SELECT SUM(colis.poid) as totalPoid FROM `colis`,loading WHERE loading.colis=colis.id AND loading.container=?;");
    $getPoid->execute([$container]);
    if ($poid = $getPoid->fetch()) {
        $totalPoid = $poid['totalPoid'];
    } else {
        $totalPoid = 0;
    }
    $ChargeMajoree = $totalCharge * $majoration;
    $PrixKilogramme = $ChargeMajoree / $totalPoid;
}
# Selection des touts les Chargements deja embarquer
$statut = 0;
$getData = $connexion->prepare("SELECT container.*,loading.container FROM `container`, `loading` WHERE loading.container=container.id AND loading.statut=?;");
$getData->execute([$statut]);
