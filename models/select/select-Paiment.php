<?php
if (isset($_GET["idadhesion"])) {
    $id = $_GET["idadhesion"];
    $getDataMod = $connexion->prepare("SELECT * FROM adhesion WHERE id=?");
    $getDataMod->execute([$id]);
    $tab = $getDataMod->fetch();
    $membreModif = $tab["membre"];
    $title = "Modifier Une cotisation";
    $btn = "Modifier";
    $url = "../models/updat/up-adhesion-post.php?idAdhesion=" . $id;
    # Selection Des données des membres
    $statut = 0;
    $getMembreMod = $connexion->prepare("SELECT * FROM `membre` WHERE membre.statut=?;");
    $getMembreMod->execute([$statut]);
} else {
    $btn = "Enregistrer";
    $Action = "../models/add/add-Paiement-post.php";
}

# Selection Des données des membres
$statut = 0;
# Selection des touts les Cotisations
$getCotisaion = $connexion->prepare("SELECT `cotisation`.*, type_cotisation.description as TypeDescription FROM `cotisation`,`type_cotisation` WHERE cotisation.type=type_cotisation.id AND cotisation.statut=?;");
$getCotisaion->execute([$statut]);

# Selection Paiement cotisation
$statut = 0;
$getPaiement = $connexion->prepare("SELECT membre.*, paiement.id, paiement.date as datePaiement, cotisation.description as nomCotisation, cotisation.montant as montant_du, SUM(paiement.montant) as montantPaye, cotisation.montant-SUM(paiement.montant) as montantRestant FROM membre, cotisation, adhesion, paiement WHERE membre.id=adhesion.membre AND adhesion.id=paiement.adhesion AND cotisation.id=paiement.cotisation AND paiement.statut=? GROUP BY membre.id, cotisation.id; ");
$getPaiement ->execute([$statut]);

 # Selection des touts les colis non encore embarquer
$getMembre = $connexion->prepare("SELECT adhesion.*,membre.nom, membre.postnom, membre.prenom, membre.photo FROM `adhesion`,`membre` WHERE adhesion.membre=membre.id AND adhesion.statut=?;");
$getMembre->execute([$statut]);

// # Selection des touts les colis non encore embarquer
// $getData = $connexion->prepare("SELECT * FROM `paiement` WHERE paiement.statut=?;");
// $getData->execute([$statut]);