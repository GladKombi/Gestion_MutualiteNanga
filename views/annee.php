<?php
// PHP includes (assumés être fonctionnels et non modifiés dans leur logique)
include '../connexion/connexion.php'; // Se connecter à la BD
require_once('../models/select/select-Annee.php'); // Appel du script de selection

// Assurez-vous que $url est définie ici si elle ne l'est pas déjà dans un autre include.
// Par exemple, si $url est pour le formulaire d'ajout/modification:
// $url = isset($_GET['editId']) ? 'models/update/update-annee.php' : 'models/add/add-annee.php';
// Pour cet exemple, je vais la définir comme une chaîne vide si elle n'est pas déjà là.
if (!isset($url)) {
    $url = '#'; // URL par défaut si non définie
}
?>
<!DOCTYPE html>
<html lang="fr" class="dark">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Années </title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#1D4ED8' // Vert plus sombre (green-700)
                    }
                }
            }
        };
    </script>

    <!-- Simple-DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" />

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        /* Styles pour simple-datatables */
        .dataTable-wrapper .dataTable-top {
            @apply mb-4 flex justify-between items-center;
        }

        .dataTable-wrapper .dataTable-input {
            @apply p-2 border rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white;
        }

        .dataTable-wrapper .dataTable-selector {
            @apply p-1 border rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white;
        }

        .dataTable-wrapper .dataTable-pagination .active a {
            @apply bg-primary text-white;
        }

        .dataTable-wrapper .dataTable-pagination a {
            @apply px-3 py-1 border rounded border-gray-300 dark:border-gray-600 text-gray-700 dark:text-white hover:bg-green-100 dark:hover:bg-gray-700;
        }

        /* Padding-bottom pour le footer fixe */
        body {
            padding-bottom: 40px;
            /* Hauteur approximative du footer */
        }

        /* Styles personnalisés pour Select2 afin qu'il s'intègre avec Tailwind */
        .select2-container--default .select2-selection--single {
            @apply p-2 border rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white h-auto;
            /* Ajuste le padding, la bordure et les couleurs */
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            @apply border-t-gray-700 dark:border-t-gray-200;
            /* Couleur de la flèche */
        }

        .select2-container--default .select2-dropdown {
            @apply border rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700;
            /* Fond du dropdown */
        }

        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            @apply bg-primary text-white;
            /* Couleur de survol des options */
        }

        .select2-container--default .select2-results__option {
            @apply text-gray-800 dark:text-white;
            /* Couleur du texte des options */
        }

        .select2-search--dropdown .select2-search__field {
            @apply p-2 border rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white;
            /* Champ de recherche dans le dropdown */
        }
    </style>
</head>

<body class="bg-white dark:bg-gray-900 text-gray-800 dark:text-white">

    <!-- Navbar (remplace navbar.php) -->
    <nav class="flex justify-between items-center px-4 py-3 bg-primary text-white shadow-md">
        <button id="menuToggle" class="md:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <div class="text-xl font-bold">MonLogo</div>

        <div class="flex items-center gap-4">
            <button onclick="toggleDarkMode()" id="darkModeToggle" class="p-2 rounded hover:bg-green-800 text-white">
                <!-- Moon -->
                <svg id="moonIcon" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M21 12.79A9 9 0 0111.21 3a7 7 0 108.59 9.79z" />
                </svg>
                <!-- Sun -->
                <svg id="sunIcon" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="12" cy="12" r="5" />
                    <path d="M12 1v2m0 18v2m11-11h-2M3 12H1m16.95 6.95l-1.41-1.41M6.46 6.46 5.05 5.05m12.02 0-1.41 1.41M6.46 17.54l-1.41 1.41" />
                </svg>
            </button>

            <div class="relative">
                <button id="profileBtn" class="w-10 h-10 rounded-full overflow-hidden border-2 border-white">
                    <img src="https://i.pravatar.cc/40" alt="Profil" />
                </button>
                <div id="profileMenu" class="hidden absolute right-0 mt-2 w-48 bg-white text-black dark:bg-gray-700 dark:text-white rounded shadow-lg py-2 z-50">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Profil</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Paramètres</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Déconnexion</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex min-h-screen">
        <!-- Sidebar (remplace Active.php et aside1.php) -->
        <aside id="sidebar" class="w-64 bg-white dark:bg-gray-800 shadow-md md:block hidden fixed md:relative z-40">
            <nav class="flex flex-col p-4 space-y-4 text-gray-700 dark:text-gray-100">
                <!-- L'état actif pourrait être géré ici via PHP ou JS si nécessaire -->
                <a href="#" class="flex items-center gap-2 hover:text-primary font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        <path d="M9 22V12h6v10" />
                    </svg>
                    Dashboard
                </a>
                <a href="#" class="flex items-center gap-2 hover:text-primary font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 00-3-3.87M7 21v-2a4 4 0 013-3.87m5-1.13a4 4 0 10-8 0 4 4 0 008 0z" />
                    </svg>
                    Utilisateurs
                </a>
                <!-- Exemple de lien pour "Année" qui pourrait être actif si $ActiveAnee est 1 -->
                <a href="AnneeScolaire.php" class="flex items-center gap-2 font-semibold 
            <?php echo (isset($ActiveAnee) && $ActiveAnee == 1) ? 'text-primary' : 'hover:text-primary'; ?>">
                    <i class="bi bi-calendar"></i> Année Scolaire
                </a>
                <a href="#" class="flex items-center gap-2 hover:text-primary font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="3" />
                        <path d="M19.4 15a1.65 1.65 0 000-6m-14.8 6a1.65 1.65 0 000-6m10.6-5.1a1.65 1.65 0 00-2.2 0M6.4 4.9a1.65 1.65 0 012.2 0m0 14.2a1.65 1.65 0 00-2.2 0m10.6 0a1.65 1.65 0 002.2 0" />
                    </svg>
                    Paramètres
                </a>
            </nav>
        </aside>

        <div id="overlay" class="hidden fixed inset-0 bg-black bg-opacity-40 z-30 md:hidden"></div>

        <!-- Main Content (remplace div id="main" et main-content container-fluid) -->
        <main id="mainContent" class="flex-1 p-6 pt-4 transition-all duration-300">
            <!-- pour afficher les messages -->
            <?php if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])) { ?>
                <div class="bg-blue-100 text-blue-800 p-3 rounded-md text-center mb-4">
                    <?= $_SESSION['msg'] ?>
                </div>
            <?php unset($_SESSION['msg']);
            } ?>

            <!-- Le form qui enregistrer les données -->
            <div class="w-full mb-6"> <!-- col-xl-12 col-lg-12 col-md-12 -->
                <form action="<?= $url ?>" class="bg-white dark:bg-gray-800 shadow p-6 rounded-lg" method="POST">
                    <h5 class="text-center text-2xl font-bold text-primary mb-4">Nouvelle Année </h5>
                    <?php if (isset($_GET['NewYeah'])) { ?>
                        <div class="flex justify-center"> <!-- row -->
                            <a href="../models/add/add-annee.php?btn=annee" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-green-800 flex items-center gap-2">
                                <i class="bi bi-plus"></i> Ajouter Nouvelle Année 
                            </a>
                        </div>
                    <?php } else { ?>
                        <div class="flex justify-center"> <!-- row -->
                            <a href="annee.php?NewYeah" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-green-800 flex items-center gap-2">
                                <i class="bi bi-calendar"></i> Nouvelle année
                            </a>
                        </div>
                    <?php } ?>
                </form>
            </div>

            <!-- La table qui affiche les données -->
            <div class="w-full overflow-x-auto px-3 pt-3"> <!-- col-xl-12 col-lg-12 col-md-8 table-responsive px-3 pt-3 -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded shadow"> <!-- card -->
                    <h3 class="text-center text-2xl font-bold text-primary mb-4">L'année académique actuelle</h3>
                    <?php
                    // Assurez-vous que $getData est réinitialisé ou exécuté à nouveau ici
                    // si vous avez besoin des données pour cette section après le formulaire.
                    // Par exemple: $getData = $conn->query("SELECT libelle, libelle2 FROM annee_scolaire WHERE active = 1");
                    // Pour cet exemple, je vais simuler quelques données si $getData n'est pas disponible ou vide.
                    if (isset($getData)) {
                        // Réinitialiser le pointeur si déjà parcouru
                        if (method_exists($getData, 'execute')) {
                            $getData->execute();
                        } else if (method_exists($getData, 'rewind')) {
                            $getData->rewind();
                        }

                        $foundData = false;
                        while ($idCatFrais = $getData->fetch()) {
                            $foundData = true;
                    ?>
                            <h3 class="text-center text-xl font-semibold text-gray-800 dark:text-gray-200"><?= $idCatFrais['libelle'] . " - " . $idCatFrais['libelle2'] ?></h3>
                    <?php
                        }
                        if (!$foundData) {
                            echo '<p class="text-center text-gray-500 dark:text-gray-400">Aucune année académique actuelle trouvée.</p>';
                        }
                    } else {
                        echo '<p class="text-center text-gray-500 dark:text-gray-400">Données non disponibles. Vérifiez la connexion ou la requête.</p>';
                    }
                    ?>
                </div>
            </div>
        </main>
    </div>

    <!-- Footer fixe moins voyant (remplace footer.php) -->
    <footer class="fixed bottom-0 left-0 w-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-center text-sm p-2 shadow-inner z-50">
        <p>&copy; 2025 Mon Dashboard. Tous droits réservés.</p>
    </footer>

    <!-- Scripts (remplace script.php) -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" defer></script>
    <!-- jQuery (nécessaire pour Select2) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Fonction pour appliquer le mode
        function applyTheme(theme) {
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }

        // Fonction pour basculer le mode et l'enregistrer
        function toggleDarkMode() {
            if (document.documentElement.classList.contains('dark')) {
                applyTheme('light');
                localStorage.setItem('theme', 'light');
            } else {
                applyTheme('dark');
                localStorage.setItem('theme', 'dark');
            }
        }

        // Fonction pour ouvrir un modal (si vous en avez un pour d'autres usages)
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        }

        // Fonction générique pour fermer un modal
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }

        // Au chargement du DOM, vérifier le localStorage pour la préférence
        document.addEventListener("DOMContentLoaded", function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                applyTheme(savedTheme);
            }

            // Initialisation de Simple-DataTables (si un tableau avec cet ID existe)
            const userTable = document.querySelector("#userTable"); // L'ID du tableau dans votre code original
            if (userTable) {
                new simpleDatatables.DataTable(userTable, {
                    searchable: true,
                    perPage: 5,
                    perPageSelect: [5, 10, 20],
                    labels: {
                        placeholder: "Rechercher...",
                        perPage: "{select} lignes par page",
                        noRows: "Aucune donnée à afficher",
                        info: "Page {page} sur {pages}"
                    }
                });
            }

            // Initialisation de Select2 (pour les selects avec la classe select2-enable)
            $('.select2-enable').select2({
                placeholder: "Rechercher ou sélectionner...",
                allowClear: true
            });

            // Menu profil
            const profileBtn = document.getElementById('profileBtn');
            const profileMenu = document.getElementById('profileMenu');
            profileBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                profileMenu.classList.toggle('hidden');
            });
            window.addEventListener('click', function(e) {
                if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
                    profileMenu.classList.add('hidden');
                }
            });

            // Menu mobile
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.getElementById('menuToggle');
            const overlay = document.getElementById('overlay');
            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('hidden');
                overlay.classList.toggle('hidden');
            });
            overlay.addEventListener('click', () => {
                sidebar.classList.add('hidden');
                overlay.classList.add('hidden');
            });
        });
    </script>
</body>

</html>