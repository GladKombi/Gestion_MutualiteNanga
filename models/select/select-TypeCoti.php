<?php
if (isset($_GET['idType'])) {
    $id = $_GET['idType'];
    $getDataMod = $connexion->prepare("SELECT * FROM type_cotisation WHERE id=?");
    $getDataMod->execute([$id]);
    $tab = $getDataMod->fetch();
    $url = "../models/updat/up-type_cotisation-post.php?idType=" . $id;
    $btn = "Modifier";
    $title="Modifier type de cotisation";
} else {
    /**
     * Ici je specifie le lien lors qu'il s'agit de l'enregistrement, ce lien montre ou il faut allez faire l'enregistrement 
     * Et changer le texte de bouton pour que les utiliseures sachent s'il s'agit de quel action
     */
    $url = "../models/add/add-typCotisation-post.php";
    $btn = "Enregistrer";
}
$statut=0;
$getData = $connexion->prepare("SELECT * FROM `type_cotisation` WHERE statut=?");
$getData->execute([$statut]);
