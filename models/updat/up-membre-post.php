<?php
include('../../connexion/connexion.php');
#modification
if (isset($_POST['Valider']) && !empty($_GET['Idmemb'])) {
    $id = $_GET['Idmemb'];
    $nom = htmlspecialchars($_POST['nom']);
    $postnom = htmlspecialchars($_POST['postnom']);
    $mail = htmlspecialchars($_POST['mail']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $Adress = htmlspecialchars($_POST['adresse']);
    $fonction = htmlspecialchars($_POST['fonction']);
    $pwd = htmlspecialchars($_POST['pwd']);
    $statut = 0;

    #verifier si l'utilisateur existe ou pas dans la bd
    $getUserDeplicant = $connexion->prepare("SELECT * FROM `membre` WHERE nom=? AND postnom=? AND prenom=? AND adresse=? AND email=?  AND fonction=? AND pwd=?  AND statut=?");
    $getUserDeplicant->execute([$nom, $postnom, $prenom, $Adress, $mail, $fonction, $pwd, $statut]);
    $tab = $getUserDeplicant->fetch();
    if ($tab > 0) {
        $_SESSION['msg'] = "Modification reussie !";
        header("location:../../views/membre.php");
    } elseif ($tab == 0) {
        $getUserDeplicant = $connexion->prepare("SELECT * FROM `membre` WHERE email=? AND id!=? AND statut=?");
        $getUserDeplicant->execute([$mail, $id, $statut]);
        $tab = $getUserDeplicant->fetch();
        if ($tab > 0) {
            $_SESSION['msg'] = "Un membre avec un mail similaire existe deja dans la base donnee !";
            header("location:../../views/membre.php");
        } else {
            $req = $connexion->prepare("UPDATE `membre` SET nom=?, postnom=?, prenom=?, email=?, adresse=?, fonction=?, pwd=? WHERE id='$id'");
            $resultat = $req->execute([$nom, $postnom, $prenom, $mail, $Adress, $fonction,$pwd]);
            if ($resultat == true) {
                $_SESSION['msg'] = "La modification a été effectuer avec succèsse";
                header("location:../../views/membre.php");
            } else {
                $_SESSION['msg'] = "Echec de la modification";
                header("location:../../views/membre.php");
            }
        }
    }
} else {

    header("location:../../views/membre.php");
}
