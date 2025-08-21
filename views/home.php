<?php
# Connexion à la BD
include '../connexion/connexion.php'; //
# Appel de la page qui fait les affichages
require_once('../models/select/select-cotisation.php');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Js_Butembo</title>
    <?php require_once('style.php') ?>

</head>

<body class="bg-white dark:bg-gray-900 text-gray-800 dark:text-white flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <?php require_once('aside.php') ?>

    <div class="flex-1 flex flex-col">
        <!-- NAVBAR -->
        <header class="flex items-center justify-between bg-white dark:bg-gray-800 shadow px-4 py-3">
            <h2 class="text-lg font-semibold text-primary">Js_Butembo</h2>
            <div class="flex items-center gap-4">
                <button onclick="toggleDarkMode()" class="text-gray-600 dark:text-white">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 2zM10 14a4 4 0 100-8 4 4 0 000 8zm0 1.25a5.25 5.25 0 110-10.5 5.25 5.25 0 010 10.5z" />
                    </svg>
                </button>
                <img src="https://i.pravatar.cc/40" class="w-8 h-8 rounded-full cursor-pointer" />
            </div>
        </header>

        <!-- MAIN -->
        <main class="p-4 overflow-auto">
             <div class="container mx-auto">
                <h1 class="text-2xl font-bold mb-6 text-center mt-10">Bienvenue sur Mon JeuneSolidaires_MangementSoftware</h1>
                <p class="text-gray-700 dark:text-gray-300 texte-center mt-10">
                    Vivez une experience utlisateur sans précedent avec notre logiciel de gestion de caisse de camion. 
                    Notre interface intuitive et nos fonctionnalités avancées vous permettent de gérer efficacement vos opérations, de suivre vos transactions et d'optimiser votre productivité. 
                    Que vous soyez un professionnel du transport ou un gestionnaire de flotte, notre solution est conçue pour répondre à vos besoins spécifiques. 
                    Découvrez comment notre logiciel peut transformer votre façon de travailler et améliorer la rentabilité de votre entreprise.
                </p>
            </div>

        </main>
    </div>

   
    <?php require_once('script.php') ?>
</body>

</html>