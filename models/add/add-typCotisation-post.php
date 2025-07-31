<?php
# Cette ligne permet d'étabir la connexion à la base de données
include('../../connexion/connexion.php');
if (isset($_POST['Valider'])) {
    $description = htmlspecialchars($_POST['description']);
    $statut = 0;
    if (!empty($description)) {
        #verifier si l'utilisateur existe ou pas dans la bd
        $getCatDeplicant = $connexion->prepare("SELECT * FROM `type_cotisation` WHERE `description`=? AND `statut`=?");
        $getCatDeplicant->execute([$description, $statut]);
        $tab = $getCatDeplicant->fetch();
        if ($tab > 0) {
            $_SESSION['msg'] = "Il existe deja un type de cotisation similaire dans la base de donées. Verifier SVP!";
            header("location:../../views/typeCotisation.php");
        } else {
            # Insertion data from database
            $req = $connexion->prepare("INSERT INTO type_cotisation(`description`, statut) values (?,?)");
            $resultat = $req->execute([$description, $statut]);
            #Si oui, la variable resultat va retourée true, donc il y a eu un enregistrement
            if ($resultat == true) {
                $_SESSION['msg'] = "Une nouveau type de Cotisation viens d'etre ajouter !"; 
                header("location:../../views/typeCotisation.php");
            } else {
                $_SESSION['msg'] = "Echec d'enreigistrement"; 
                header("location:../../views/typeCotisation.php");
            }
        }
    } else {
        $_SESSION['msg'] = "Veillez Vefier les champs Svp !"; 
        header("location:../../views/typeCotisation.php");
    }
} else {
    header("location:../../views/typeCotisation.php");
}
