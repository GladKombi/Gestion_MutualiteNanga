<?php
include('../../connexion/connexion.php');

if (isset($_POST['Valider']) && !empty($_GET['idType'])) {
  $id = $_GET['idType'];
  $description = htmlspecialchars($_POST['description']);

  #verifier si la cat a été modifier
  $getCategorieDeplicant = $connexion->prepare("SELECT * FROM type_cotisation WHERE `description`=? AND `statut`=? AND id=?");
  $getCategorieDeplicant->execute([$description, 0, $id]);
  $tab = $getCategorieDeplicant->fetch();
  if ($tab > 0) {
    $_SESSION['msg'] = "La modification réussi !"; //Cette variable recoit le message pour notifier l'utilisateur de l'opération qu'il deja fait
    header("location:../../views/typeCotisation.php");
  } elseif ($tab == 0) {
    #verifier si la cat existe ou pas dans la bd
    $getCatDeplicant = $connexion->prepare("SELECT * FROM type_cotisation WHERE `description`=? AND id!=? AND `statut`=?");
    $getCatDeplicant->execute([$description, $id, 0]);
    $tab = $getCatDeplicant->fetch();
    if ($tab > 0) {
      $_SESSION['msg'] = "Cette catégorie existe dejà dans la base de données !"; //Cette variable recoit le message pour notifier l'utilisateur de l'opération qu'il deja fait
      header("location:../../views/typeCotisation.php?idType=" . $id);
    } else {
      $req = $connexion->prepare("UPDATE `type_cotisation` SET description=?  WHERE id=?");
      $resultat = $req->execute([$description, $id]);
      #Si oui, la variable resultat va retourée true, donc il y a eu une modification
      if ($resultat == true) {
        $_SESSION['msg'] = "La modification réussi !"; 
        header("location:../../views/typeCotisation.php");
      } else {
        $_SESSION['msg'] = "Echec de la modification !"; 
        header("location:../../views/typeCotisation.php?idcat=" . $id);
      }
    }
  }
} else {
  //Cette ligne permet de rediriger l'utiliseteur lors qu'il a pas cliquer sur le button qui sert à modifier
  header("location:../../views/typeCotisation.php");
}
