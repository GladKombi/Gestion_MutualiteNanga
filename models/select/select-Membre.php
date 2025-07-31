<?php
if (isset($_GET['idMembre'])) {
    $id = $_GET['idMembre'];
    $getDataMod = $connexion->prepare("SELECT `membre`.* FROM `membre` WHERE `membre`.id=?");
    $getDataMod->execute([$id]);
    $tab = $getDataMod->fetch();
    $url = "../models/updat/up-membre-post.php?Idmemb=" . $id;
    $btn = "Modifier";
    $title = "Modifier un membre";
} elseif (isset($_GET["Sup"])) {
    $id = $_GET['Sup'];
    $url = "../models/delete/del-member.php?idSupMemb=" . $id;
} else {
    /**
     * Ici je specifie le lien lors qu'il s'agit de l'enregistrement, ce lien montre ou il faut allez faire l'enregistrement 
     * Et changer le texte de bouton pour que les utiliseures sachent s'il s'agit de quel action
     */
    $url = "../models/add/add-membre-post.php";
    $title = "Ajouter un membre";
    $btn = "Enregistrer";
}
$statut = 0;
$approbation = 1;
# Selection des membres
$getData = $connexion->prepare("SELECT `membre`.* FROM `membre` WHERE  `membre`.statut=? AND `membre`.approbation=? ORDER BY membre.id Desc;");
$getData->execute([$statut, $approbation]);
