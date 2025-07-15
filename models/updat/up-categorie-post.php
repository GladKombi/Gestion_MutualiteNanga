<?php
include('../../connexion/connexion.php');

if (isset($_POST['Valider']) && !empty($_GET['idcat'])) {
  $id = $_GET['idcat'];
  $description = htmlspecialchars($_POST['description']);

  #verifier si la cat a été modifier
  $getCategorieDeplicant = $connexion->prepare("SELECT * FROM categorie WHERE `description`=? AND `statut`=? AND id=?");
  $getCategorieDeplicant->execute([$description, 0, $id]);
  $tab = $getCategorieDeplicant->fetch();
  if ($tab > 0) {
    $_SESSION['msg'] = "La modification réussi !"; //Cette variable recoit le message pour notifier l'utilisateur de l'opération qu'il deja fait
    header("location:../../views/categorie.php");
  } elseif ($tab == 0) {
    #verifier si la cat existe ou pas dans la bd
    $getCatDeplicant = $connexion->prepare("SELECT * FROM categorie WHERE `description`=? AND `statut`=?");
    $getCatDeplicant->execute([$description, 0]);
    $tab = $getCatDeplicant->fetch();
    if ($tab > 0) {
      $_SESSION['msg'] = "Cette catégorie existe dejà dans la base de données !"; //Cette variable recoit le message pour notifier l'utilisateur de l'opération qu'il deja fait
      header("location:../../views/categorie.php?idCategorie=" . $id);
    } else {
      $req = $connexion->prepare("UPDATE `categorie` SET description=?  WHERE id='$id'");
      $resultat = $req->execute([$description]);
      #Si oui, la variable resultat va retourée true, donc il y a eu une modification
      if ($resultat == true) {
        $_SESSION['msg'] = "La modification réussi !"; //Cette ligne permet d'ajouter un message dans la session Lors qu'il y a eu un enregistrement
        header("location:../../views/categorie.php");
      } else {
        $_SESSION['msg'] = "Echec de la modification !"; //Cette ligne permet d'ajouter un message dans la session Lors qu'il n'y a aucune modification
        header("location:../../views/categorie.php?idcat=" . $id);
      }
    }
  }
} else {
  //Cette ligne permet de rediriger l'utiliseteur lors qu'il a pas cliquer sur le button qui sert à modifier
  header("location:../../views/categorie.php");
}
