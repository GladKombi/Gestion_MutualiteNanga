<?php
if (isset($_GET["idcolis"])) {
    $id = $_GET["idcolis"];
    $getDataMod = $connexion->prepare("SELECT * FROM colis WHERE id=?");
    $getDataMod->execute([$id]);
    $tab = $getDataMod->fetch();
    $MembersModif=$tab["member"];
    $title = "Modifier les information du colis" ;
    $btn = "Modifier";
    $url = "../models/updat/up-colis-post.php?idColis=" . $id;
}
elseif (isset($_GET["Supcolis"])){
    $idSup=$_GET["Supcolis"];
    $getDataSup = $connexion->prepare("SELECT `colis`.*, membre.nom, membre.postnom, membre.prenom, membre.telephone FROM `colis`,`membre` WHERE colis.member=membre.id AND colis.id=?");
    $getDataSup->execute([$idSup]);
    $tab = $getDataSup->fetch();
    $poid = $tab['poid'];
    $nom = $tab['nom'];
    $postnom = $tab['postnom'];
    $prenom = $tab['prenom'];
    $telephone = $tab['telephone'];
    $url = "../models/delete/del-colis.php?idSupColis=" . $idSup;
} else {
    $title = "Nouveau colis";
    $btn = "Enregistrer";
    $url = "../models/add/add-Package-post.php";
}

# Selection Des données des membres
$statut=0;
$getMember = $connexion->prepare("SELECT * FROM `membre` WHERE membre.statut=? ORDER BY `membre`.`id` DESC;");
$getMember->execute([$statut]);
# Selection des touts les colis non encore embarquer
$getData = $connexion->prepare("SELECT `colis`.*, membre.nom, membre.postnom, membre.prenom, membre.telephone FROM `colis`,`membre` WHERE colis.member=membre.id AND colis.statut=?;");
$getData->execute([$statut]);
