<?php
if (isset($_GET['Colis'])) {
    $Colis = $_GET["Colis"];
    $getColisDetail = $connexion->prepare("SELECT `colis`.*,membre.matricule, membre.nom, membre.postnom, membre.prenom, membre.telephone FROM `colis`,`membre` WHERE colis.member=membre.id AND colis.id=? ");
    $getColisDetail->execute([$Colis]);
    $Details = $getColisDetail->fetch();
}
