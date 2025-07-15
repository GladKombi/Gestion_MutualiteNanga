<?php
if (isset($_GET['idCommand'])) {
    $id = $_GET['idCommand'];
    $getDataMod = $connexion->prepare("SELECT * FROM command WHERE id=?");
    $getDataMod->execute([$id]);
    $tab = $getDataMod->fetch();

    #Ici je specifie le lien lors qu'il s'agit de la modification, 
    $url = "../models/updat/up-utilisateur-post.php?idCommand=" . $id;
    $btn = "Modify";
    $title = "Modify a command";
} elseif (isset($_GET['ViewCommand'])) {
    $id = $_GET['ViewCommand'];
    $SelectCom = $connexion->prepare("SELECT * FROM command WHERE id=?");
    $SelectCom->execute([$id]);
    $ShowCom = $SelectCom->fetch();
    # The selection of command details
    $getData = $connexion->prepare("SELECT command.date, command.description, command.quantite as QuantiteTot, command.photo, user.nom, user.prenom, participants.* FROM `command`,user,participants WHERE participants.commad=command.id AND participants.user=user.id AND command.id=?;");
    $getData->execute([$id]);
} else {
    #Ici je specifie le lien lors qu'il s'agit de l'enregistrement
    $url = "../models/add/add-Command-post.php";
    $btn = "Save";
    $title = "Add a new Command";
}
