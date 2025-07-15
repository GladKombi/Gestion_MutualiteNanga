<?php
if (isset($_GET["loading"])) {
    # Recuperation du dernier container
    if (isset($_GET["container"])) {
        $LastestContainer = $_GET["container"];
    } else {
        $getLastContai = $connexion->prepare("SELECT * FROM `container` ORDER BY id DESC LIMIT 1 ");
        $getLastContai->execute();
        if ($mat = $getLastContai->fetch()) {
            $containerId= $mat['id'];
            $LastestContainer = $mat['id']." - ".$mat['date']." ".$mat['chauffeur'];
        }
    }
    $title = "Chargement des colis";
    $btn = "Enregistrer";
    $url = "../models/add/add-PackageLoad-post.php?container=" . $containerId;
} else {
    $_SESSION['msg'] = "Registration fail";
    header("location:../views/cargaison.php");
}

# Selection des touts les colis non encore embarquer
$statut = 0;
$getcolis = $connexion->prepare("SELECT `colis`.*,membre.nom, membre.matricule, membre.postnom, membre.prenom, membre.telephone FROM `colis`,`membre` WHERE colis.id NOT IN (SELECT loading.colis FROM loading) AND colis.member=membre.id AND colis.statut=?;");
$getcolis->execute([$statut]);
# Selection Des colis deja charges
$getData = $connexion->prepare("SELECT `loading`.*,membre.id,membre.nom, membre.matricule,membre.postnom,membre.prenom,colis.poid, membre.telephone FROM `loading`,`membre`,`colis` WHERE loading.colis=colis.id AND colis.member=membre.id AND loading.statut=? and loading.container=? ORDER BY `loading`.`id` DESC;");
$getData->execute([$statut, $LastestContainer]);
