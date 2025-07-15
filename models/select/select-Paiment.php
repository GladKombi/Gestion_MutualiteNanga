<?php
# Recuperation du dernier container
if (isset($_GET["container"])) {
    $container = $_GET["container"];
    $title = "Paiement";
    $btn = "Enregistrer";
    $url = "../models/add/add-Paiement-post.php?container=" . $container;
    # Selection des colis dans le container
    $statut = 0;
    $getcolis = $connexion->prepare("SELECT `colis`.*,membre.nom, membre.matricule, membre.postnom, membre.prenom, membre.telephone FROM `colis`,`membre`,loading WHERE loading.colis=colis.id AND loading.container=? AND colis.member=membre.id AND loading.statut=? AND colis.id NOT IN(SELECT paiement.colis FROM paiement WHERE paiement.statut=0);");
    $getcolis->execute([$container, $statut]);
    # Selection Des paiements deja enregistrer 
    $getPaiement = $connexion->prepare("SELECT `colis`.*,paiement.date as datePaie,paiement.colis as selColis,paiement.id as IdPaie ,membre.nom, membre.matricule, membre.postnom, membre.prenom, membre.telephone, paiement.montant FROM `colis`,`membre`,paiement WHERE paiement.colis=colis.id AND paiement.container=? AND colis.member=membre.id AND paiement.statut=? ORDER BY `paiement`.`id` DESC;");
    $getPaiement->execute([$container, $statut]);
    # Detail du containeur
    $getContainer = $connexion->prepare("SELECT * FROM `container` WHERE container.id=? ");
    $getContainer->execute([$container]);
    if ($mat = $getContainer->fetch()) {
        $containerId = $mat['id'];
        $LastestContainer = $mat['id'] . " - " . $mat['date'] . " " . $mat['chauffeur'];
    }
    ## Calcul du prix par kilogramme

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
    # Selection du montant à payer pour chacun
    $getPaieAmount = $connexion->prepare("SELECT `colis`.*,membre.nom, membre.matricule, membre.postnom, membre.prenom, membre.telephone FROM `colis`,`membre`,dechargement WHERE dechargement.colis=colis.id AND dechargement.container=? AND colis.member=membre.id AND dechargement.statut=? ORDER BY `dechargement`.`id` DESC;");
    $getPaieAmount->execute([$container, $statut]);
} elseif (isset($_GET["SupDechag"])) {
    $idSup = $_GET["SupDechag"];
    $title = "Supprimer le colis";
    $btn = "Supprimer";
    $url = "../models/delete/del-dechargement.php?idDecharg=" . $idSup;
    $getContainer = $connexion->prepare("SELECT container FROM dechargement WHERE dechargement.id=? ");
    $getContainer->execute([$idSup]);
    if ($mat = $getContainer->fetch()) {
        $container = $mat[0];
    }
}
# Selection des touts les Chargements deja embarquer
$statut = 0;
$getData = $connexion->prepare("SELECT DISTINCT container.* FROM `container` INNER JOIN `dechargement` ON dechargement.container = container.id AND container.statut=?;");
$getData->execute([$statut]);
