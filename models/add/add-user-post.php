<?php
#inclusion de la page de connexion
include('../../connexion/connexion.php');
require_once ('../../fonctions/fonctions.php');
// creation de l'evenement sur le bouton valider
if (isset($_POST['valider'])) {
  $nom = htmlspecialchars($_POST['firstName']);
  $postnom = htmlspecialchars($_POST['name']);
  $prenom = htmlspecialchars($_POST['LastName']);
  $phone = htmlspecialchars($_POST['phone']);
  $password = htmlspecialchars($_POST['pwd']);
  $statut = 0;
  $etat = 0;
  // $image = $_FILES['picture']['name'];
  // $file = $_FILES['picture'];
  $fichier_tmp = $_FILES['picture']['tmp_name'];
  $nom_original = $_FILES['picture']['name'];
  $destination = "../../assets/profil/";
  // fonction permettant de recuperer la photo
  $newimage = RecuperPhoto($fichier_tmp, $nom_original, $destination);
  /**
   * Here’s the translation of your logic into English: “Here, we have hashed the password. So, for a new user, you first need to create a file that will allow you to hash the password in order to log in. Please create this file outside of this ‘dk’ project.”
   * for example
   * $pwd=1234;
   * $hash = password_hash($pwd, PASSWORD_DEFAULT);
   * print $hash;
   */

  // password hashing
  // $passwordh=$password;
  // $passwordhacher=password_hash($passwordh, PASSWORD_DEFAULT);

  if (is_numeric($phone)) {
    #verifier si l'utilisateur existe ou pas dans la bd
    $getUserDeplicant = $connexion->prepare("SELECT * FROM `user` WHERE phone=? AND statut=? AND etat=?");
    $getUserDeplicant->execute([$phone, $statut, $etat]);
    $tab = $getUserDeplicant->fetch();
    if ($tab > 0) {
      $_SESSION['msg'] = "That user is already in the database !";
      header("location:../../views/user.php");
    } else {
      // verify pwd vadity
      if ($password != "") {
        //Insertion data from database
        $req = $connexion->prepare("INSERT INTO `user`(`nom`, `postnom`, `prenom`, `phone`, `photo`, `pwd`, `statut`, `etat`) VALUES (?,?,?,?,?,?,?,?)");
        $resultat = $req->execute([$nom, $postnom, $prenom, $phone, $newimage, $password, $statut, $etat]);
        if ($resultat == true) {
          $_SESSION['msg'] = "Successful registration !";
          header("location:../../views/user.php");
        } else {
          $_SESSION['msg'] = "Failed to register !";
          header("location:../../views/user.php");
        }
      } else {
        $_SESSION['msg'] = "Enter a valid Password";
        header("location:../../views/user.php");
      }
    }
  } else {
    $_SESSION['msg'] = "The phone number must not be a string !s";
    header("location:../../views/user.php");
  }
} else {
  header("location:../../views/user.php");
}
