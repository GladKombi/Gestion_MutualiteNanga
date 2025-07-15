<?php

/**
 * Cette fonction nous aide à recuperer la photo, la deplace, et renvoyer son nom à la base
 * de données, lors que l'extention de la photo selectionnée n'est pas recommander, ça
 * retourne 0
 * Si non, ça retourne le nom et extention de la photo ou fichier
 */
function RecuperPhoto($fichier_tmp, $nom_original, $destination)
{
    // $fichier_tmp = $_FILES['image']['tmp_name'];
    // $nom_original = $_FILES['image']['name'];
    // Extension du fichier
    $extension = strtolower(pathinfo($nom_original, PATHINFO_EXTENSION));

    // Tableau des extensions autorisées (ajoutez celles que vous souhaitez)
    $extensions_autorisees = array('jpg', 'jpeg', 'png', 'gif');

    // Vérification de l'extension
    if (in_array($extension, $extensions_autorisees)) {
        // Nouveau nom de fichier (pour éviter les doublons)
        $nouveau_nom = uniqid("JSB") . '.' . $extension;

        // Chemin complet du fichier de destination
        $chemin = $destination . $nouveau_nom;

        // Déplacement du fichier temporaire vers le dossier de destination
        if (move_uploaded_file($fichier_tmp, $chemin)) {
            return $nouveau_nom;
        } else {
            echo "Une erreur s'est produite lors du téléchargement.";
        }
    } else {
        echo "Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
    }

    // $filetmp=$file['tmp_name'];
    // $fileext = explode(('.'), $image);
    // $fileckek = strtolower(end($fileext));
    // $fileextsrom = array( 'png',  'jpg', 'jpeg');
    // if(empty($image)) {
    //     print -1;
    // } elseif (!in_array($fileckek, $fileextsrom)) {
    //     return '0';
    // }else{
    //     move_uploaded_file($filetmp, $destination);
    //     return $image;
    // }
}

/**
 * Cette fonction recuper les dernier carractere dans un string
 * Cela prénd les string à deduire et le nombre de carractère à deduire
 */
function getLastCharacters($string, $num)
{
    return substr($string, -$num);
}
