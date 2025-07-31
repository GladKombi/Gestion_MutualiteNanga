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
    $Action = "../models/add/add-adhesion-post.php";
}

# Selection Des données des membres
$statut = 0;
$getMembre = $connexion->prepare("SELECT * FROM `membre` WHERE membre.id NOT IN(SELECT adhesion.membre FROM `adhesion` WHERE adhesion.statut=0) AND membre.statut=?;");
$getMembre->execute([$statut]);
# Selection des touts les colis non encore embarquer
$getData = $connexion->prepare("SELECT adhesion.*,membre.nom, membre.postnom, membre.prenom, membre.photo FROM `adhesion`,`membre` WHERE adhesion.membre=membre.id AND adhesion.statut=?;");
$getData->execute([$statut]);
