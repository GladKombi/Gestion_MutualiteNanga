<?php
// Appel de la connexion
include_once '../../connexion/connexion.php';
// Appel de la fonction qui permet de recuperer la photo
require_once('../../fonctions/fonctions.php');
// Enregistrement de la commande
if (isset($_POST['valider'])) {
    $date = date('Y-m-d');
    $Description = htmlspecialchars($_POST['description']);
    $Quantite = htmlspecialchars($_POST['quantite']);
    $prix = htmlspecialchars($_POST['prix']);
    // $image = $_FILES['picture']['name'];
    // $file = $_FILES['picture'];
    $fichier_tmp = $_FILES['picture']['tmp_name'];
    $nom_original = $_FILES['picture']['name'];
    $destination = "../../assets/photo/";
    // fonction permettant de recuperer la photo
    $newimage = RecuperPhoto($fichier_tmp, $nom_original, $destination);
    $statut = 0;
    $etat = 0;
    // echo $newimage ;
    //requette permettant d'inserer une commande dans la base des données
    $req = $connexion->prepare("INSERT INTO `command`(`date`, `description`, `quantite`, `prix`, `photo`, `statut`, `Etat`) VALUES (?,?,?,?,?,?,?)");
    $resultat = $req->execute(array($date, $Description, $Quantite, $prix, $newimage, $statut, $etat));
    $id = $connexion->lastInsertId();
    if ($resultat == true) {
        $_SESSION['msg'] = " Votre commande viens d'être enregistrer avec succes !";
        header("location:../../views/command.php?idcom=$id");
    }
} elseif (isset($_POST['save'])) { //Ajout au participant
    $id = $_GET['idcom'];
    $user = htmlspecialchars($_POST['user']);
    $Quantite = htmlspecialchars($_POST['quantite']);

    //Recuperation de la quantité totale de la commande
    $getQuantity = $connexion->prepare("SELECT quantite FROM `command` WHERE id=?");
    $getQuantity->execute(array($id));
    if ($tab = $getQuantity->fetch()) {
        $commandQuant = $tab['quantite'];
    } else {
        $commandQuant = 0;
    }
    /**
     * Cette requette retourne la quantité déjà attribuer
     */
    $requete = $connexion->prepare("SELECT SUM(quantite) as stock FROM participants WHERE commad=?");
    $requete->execute(array($id));
    if ($table = $requete->fetch()) {
        $stockAttri = $table['stock'];
    } else {
        $stockAttri = 0;
    }
    $stockResta = $commandQuant - $stockAttri;
    // echo $stockAttri;
    // echo $stockResta;
    //Ici on verifie si quantité qu'on veux attribuer n'est pas supperieur à celle de la commande                  
    if ($Quantite > $stockResta) {
        $_SESSION['msg'] = "Please enter a valid quantity !";
        header("location:../../views/command.php?idcom=$id");
    } else {
        $statut = 0;
        $req = $connexion->prepare("INSERT INTO `participants`(`user`, `commad`, `quantite`, `statut`)  VALUES (?,?,?,?)");
        $req->execute(array($user, $id, $Quantite, $statut));
        if ($req) {
            $_SESSION['msg'] = "A new addition to the order has just been made !";
            // if (isset($_GET['idpartic'])) {
            //     header("location:../../views/command.php?idcom=$id&idpartic=0");
            // } else {
            header("location:../../views/command.php?idcom=$id");
            // }
        }
    }
} else {
    header("location:../../views/command.php");
}
