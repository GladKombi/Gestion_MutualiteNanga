<?php
if (isset($_GET['Container'])) {
    $container = $_GET['Container'];
    $getLastContai = $connexion->prepare("SELECT * FROM `container` WHERE container.id=? ");
    $getLastContai->execute([$container]);
    if ($mat = $getLastContai->fetch()) {
        $containerId = $mat['id'];
        $LastestContainer = $mat['id'] . " - " . $mat['date'] . " " . $mat['chauffeur'];
    }
    $statut = 0;
    $getDataSelCont = $connexion->prepare("SELECT `loading`.*,colis.description,membre.id,membre.nom,membre.postnom,membre.prenom,colis.poid, membre.telephone FROM `loading`,`membre`,`colis` WHERE loading.colis=colis.id AND colis.member=membre.id and loading.container=? ORDER BY `loading`.`id` DESC;");
    $getDataSelCont->execute([$container]);
}
# Selection des touts les Container
$statut=0;
$getData = $connexion->prepare("SELECT * FROM `container` WHERE container.statut=?;");
$getData->execute([$statut]);
