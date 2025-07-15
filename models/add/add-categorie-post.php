<?php
# Cette ligne permet d'étabir la connexion à la base de données
include('../../connexion/connexion.php');
if (isset($_POST['Valider'])) {
    $description = htmlspecialchars($_POST['description']);
    $statut = 0;
    if (!empty($description)) {
        #verifier si l'utilisateur existe ou pas dans la bd
        $getCatDeplicant = $connexion->prepare("SELECT * FROM `categorie` WHERE `description`=? AND `statut`=?");
        $getCatDeplicant->execute([$description, $statut]);
        $tab = $getCatDeplicant->fetch();
        if ($tab > 0) {
            $_SESSION['msg'] = "Il existe deja une categorie similaire dans la base de donées. Verifier SVP!";
            header("location:../../views/categorie.php");
        } else {
            # Insertion data from database
            $req = $connexion->prepare("INSERT INTO categorie(`description`, statut) values (?,?)");
            $resultat = $req->execute([$description, $statut]);
            #Si oui, la variable resultat va retourée true, donc il y a eu un enregistrement
            if ($resultat == true) {
                $_SESSION['msg'] = "Une nouvelle categorie viens d'etre ajouter !"; 
                header("location:../../views/categorie.php");
            } else {
                $_SESSION['msg'] = "Echec d'enreigistrement"; 
                header("location:../../views/categorie.php");
            }
        }
    } else {
        $_SESSION['msg'] = "Veillez Vefier les champs Svp !"; 
        header("location:../../views/categorie.php");
    }
} else {
    header("location:../../views/categorie.php");
}
