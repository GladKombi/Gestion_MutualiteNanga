<?php
#inclusion de la page de connexion
include('../../connexion/connexion.php');
require_once('../../fonctions/fonctions.php');

# creation de l'evenement sur le bouton valider
if (isset($_POST['Valider'])) {
    $nom = htmlspecialchars($_POST['nom']);
    $postnom = htmlspecialchars($_POST['postnom']);
    $mail = htmlspecialchars($_POST['mail']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $Adress = htmlspecialchars($_POST['adresse']);
    $fonction = htmlspecialchars($_POST['fonction']);
    $pwd = htmlspecialchars($_POST['pwd']);
    $statut = 0;

    #verifier si l'utilisateur existe ou pas dans la bd
    $getUserDeplicant = $connexion->prepare("SELECT * FROM `membre` WHERE email=? AND statut=?");
    $getUserDeplicant->execute([$mail, $statut]);
    $tab = $getUserDeplicant->fetch();
    if ($tab > 0) {
        $_SESSION['msg'] = "Un membre avec un mail similaire existe deja dans la base donnee !";
        header("location:../../views/membre.php");
    } else {
        $fichier_tmp = $_FILES['picture']['tmp_name'];
        $nom_original = $_FILES['picture']['name'];
        $destination = "../../img/";
        # fonction permettant de recuperer la photo
        $newimage = RecuperPhoto($fichier_tmp, $nom_original, $destination);
        $statut = 0;
        # Insertion data from database
        $req = $connexion->prepare("INSERT INTO `membre`(`nom`, `postnom`,`prenom`, `email`, `adresse`, `fonction`, `pwd`, `photo`, `statut`) VALUES (?,?,?,?,?,?,?,?,?)");
        $resultat = $req->execute([$nom, $postnom, $prenom, $mail, $Adress, $fonction, $pwd, $newimage, $statut]);
        if ($resultat == true) {
            $_SESSION['msg'] = "Enregistrement reussi !";
            header("location:../../views/membre.php");
        } else {
            $_SESSION['msg'] = "Echec d'enregistrement";
            header("location:../../views/membre.php");
        }
    }
} else {
    header("location:../../views/membre.php");
}
