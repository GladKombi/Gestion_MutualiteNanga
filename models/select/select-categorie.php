<?php
if (isset($_GET['idCategorie'])) {
    $id = $_GET['idCategorie'];
    $getDataMod = $connexion->prepare("SELECT * FROM categorie WHERE id=?");
    $getDataMod->execute([$id]);
    $tab = $getDataMod->fetch();
    $url = "../models/updat/up-categorie-post.php?idcat=" . $id;
    $btn = "Modifier";
    $title = "Modifier catégorie";
} elseif (isset($_GET["Sup"])) {
    $id = $_GET['Sup'];
    $getDataSup = $connexion->prepare("SELECT * FROM categorie WHERE id=?");
    $getDataSup->execute([$id]);
    $tab = $getDataSup->fetch();
    $CategorieDesci = $tab['description'];
    $url = "../models/delete/del-categorie.php?idSupcat=" . $id;
} else {
    /**
     * Ici je specifie le lien lors qu'il s'agit de l'enregistrement, ce lien montre ou il faut allez faire l'enregistrement 
     * Et changer le texte de bouton pour que les utiliseures sachent s'il s'agit de quel action
     */
    $url = "../models/add/add-categorie-post.php";
    $btn = "Enregistrer";
    $title = "Nouvelle catégorie";
}
$getData = $connexion->prepare("SELECT * FROM `categorie` WHERE statut=0");
$getData->execute();
