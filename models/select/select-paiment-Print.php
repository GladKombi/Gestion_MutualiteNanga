<?php
if (isset($_GET['idPaiment'])) {
    $idPaiment = $_GET["idPaiment"];
    # Detail du containeur
    $getContainer = $connexion->prepare("SELECT container FROM `paiement` WHERE paiement.id=? ");
    $getContainer->execute([$idPaiment]);
    if ($mat = $getContainer->fetch()) {
        $container = $mat['container'];
    }
    # Selection des charge du containeur
    $getCharge = $connexion->prepare("SELECT SUM(charge.montant) as totalCharge FROM `charge` WHERE charge.container=?;");
    $getCharge->execute([$container]);
    if ($charge = $getCharge->fetch()) {
        $totalCharge = $charge['totalCharge'];
    } else {
        $totalCharge = 0;
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

    # Selection Des paiements deja enregistrer 
    $statut = 0;
    $getPaiement = $connexion->prepare("SELECT `colis`.*,paiement.date as datePaie,paiement.colis as selColis ,membre.nom, membre.matricule, membre.postnom, membre.prenom, membre.telephone, paiement.montant FROM `colis`,`membre`,paiement WHERE paiement.colis=colis.id AND paiement.container=? AND colis.member=membre.id AND paiement.statut=? ORDER BY `paiement`.`id` DESC;");
    $getPaiement->execute([$container, $statut]);
    $DetailPay = $getPaiement->fetch();
    # le prix tolal à payer
    $prix = $PrixKilogramme * $DetailPay['poid'];
    $colisSelected = $DetailPay['selColis'];
    # Selection des montant deja Payer pour le calcul du rest
    $getMontantPayer = $connexion->prepare("SELECT SUM(paiement.montant) as TotalPaye FROM paiement WHERE paiement.colis=? ");
    $getMontantPayer->execute([$colisSelected]);
    if ($Total = $getMontantPayer->fetch()) {
        $TotalPayer = $Total['TotalPaye'];
    } else {
        $TotalPayer = 0;
    }
    # Calcul du rest à payer 
    $rest = $prix - $TotalPayer;
}
