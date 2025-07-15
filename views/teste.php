<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Carte avec Formulaire et Tableau</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            primary: '#15803D' // Vert plus sombre (green-700)
          }
        }
      }
    };
  </script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" />
  
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <style>
    /* Styles pour simple-datatables (inchangés) */
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
        padding-bottom: 40px; /* Hauteur approximative du footer */
    }

    /* Styles personnalisés pour Select2 afin qu'il s'intègre avec Tailwind */
    .select2-container--default .select2-selection--single {
        @apply p-2 border rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white h-auto; /* Ajuste le padding, la bordure et les couleurs */
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        @apply border-t-gray-700 dark:border-t-gray-200; /* Couleur de la flèche */
    }
    .select2-container--default .select2-dropdown {
        @apply border rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700; /* Fond du dropdown */
    }
    .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
        @apply bg-primary text-white; /* Couleur de survol des options */
    }
    .select2-container--default .select2-results__option {
        @apply text-gray-800 dark:text-white; /* Couleur du texte des options */
    }
    .select2-search--dropdown .select2-search__field {
        @apply p-2 border rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white; /* Champ de recherche dans le dropdown */
    }
  </style>
</head>
<body class="bg-white dark:bg-gray-900 text-gray-800 dark:text-white">

  <nav class="flex justify-between items-center px-4 py-3 bg-primary text-white shadow-md">
    <button id="menuToggle" class="md:hidden">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>
    <div class="text-xl font-bold">MonLogo</div>

    <div class="flex items-center gap-4">
      <button onclick="toggleDarkMode()" id="darkModeToggle" class="p-2 rounded hover:bg-green-800 text-white">
        <svg id="moonIcon" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path d="M21 12.79A9 9 0 0111.21 3a7 7 0 108.59 9.79z" />
        </svg>
        <svg id="sunIcon" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <circle cx="12" cy="12" r="5"/>
          <path d="M12 1v2m0 18v2m11-11h-2M3 12H1m16.95 6.95l-1.41-1.41M6.46 6.46 5.05 5.05m12.02 0-1.41 1.41M6.46 17.54l-1.41 1.41"/>
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
    <aside id="sidebar" class="w-64 bg-white dark:bg-gray-800 shadow-md md:block hidden fixed md:relative z-40">
      <nav class="flex flex-col p-4 space-y-4 text-gray-700 dark:text-gray-100">
        <a href="#" class="flex items-center gap-2 hover:text-primary font-semibold">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
            <path d="M9 22V12h6v10"/>
          </svg>
          Dashboard
        </a>
        <a href="#" class="flex items-center gap-2 hover:text-primary font-semibold">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M17 21v-2a4 4 0 00-3-3.87M7 21v-2a4 4 0 013-3.87m5-1.13a4 4 0 10-8 0 4 4 0 008 0z"/>
          </svg>
          Utilisateurs
        </a>
        <a href="#" class="flex items-center gap-2 hover:text-primary font-semibold">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="3"/>
            <path d="M19.4 15a1.65 1.65 0 000-6m-14.8 6a1.65 1.65 0 000-6m10.6-5.1a1.65 1.65 0 00-2.2 0M6.4 4.9a1.65 1.65 0 012.2 0m0 14.2a1.65 1.65 0 00-2.2 0m10.6 0a1.65 1.65 0 002.2 0"/>
          </svg>
          Paramètres
        </a>
      </nav>
    </aside>

    <div id="overlay" class="hidden fixed inset-0 bg-black bg-opacity-40 z-30 md:hidden"></div>

    <main id="mainContent" class="flex-1 p-6 pt-4 transition-all duration-300">
      <div class="bg-white dark:bg-gray-800 p-6 rounded shadow mb-6">
        <h2 class="text-2xl mb-4 font-bold text-primary">Gestion des données</h2>
        
        <div class="flex flex-col md:flex-row gap-6">
          <div class="w-full md:w-4/12 p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
            <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Filtrer les données</h3>
            <form class="space-y-4">
              <div>
                <label for="select1" class="block mb-1 font-semibold">Critère 1</label>
                <select id="select1" class="w-full select2-enable"> 
                  <option value="">Sélectionnez une option</option>
                  <option value="optionA">Option A - Très Longue Description</option>
                  <option value="optionB">Option B - Autre Choix Possible</option>
                  <option value="optionC">Option C - Troisième Alternative</option>
                  <option value="optionD">Option D</option>
                  <option value="optionE">Option E</option>
                  <option value="optionF">Option F</option>
                </select>
              </div>
              <div>
                <label for="select2" class="block mb-1 font-semibold">Critère 2</label>
                <select id="select2" class="w-full select2-enable">
                  <option value="">Sélectionnez une option</option>
                  <option value="itemX">Item X de la liste</option>
                  <option value="itemY">Item Y important</option>
                  <option value="itemZ">Item Z final</option>
                  <option value="itemA">Item A</option>
                  <option value="itemB">Item B</option>
                  <option value="itemC">Item C</option>
                </select>
              </div>
              <div>
                <label for="select3" class="block mb-1 font-semibold">Critère 3</label>
                <select id="select3" class="w-full select2-enable">
                  <option value="">Sélectionnez une option</option>
                  <option value="cat1">Catégorie 1</option>
                  <option value="cat2">Catégorie 2</option>
                  <option value="cat3">Catégorie 3</option>
                  <option value="cat4">Catégorie 4</option>
                  <option value="cat5">Catégorie 5</option>
                  <option value="cat6">Catégorie 6</option>
                </select>
              </div>
              <button type="submit" class="px-4 py-2 bg-primary text-white rounded hover:bg-green-800">Appliquer les filtres</button>
            </form>
          </div>

          <div class="w-full md:w-8/12 p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
            <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Résultats du tableau</h3>
            <div class="overflow-x-auto">
              <table id="dataTableExample" class="w-full table-auto border-collapse">
                <thead>
                  <tr class="bg-green-100 dark:bg-gray-700 text-left">
                    <th class="p-2">ID</th>
                    <th class="p-2">Produit</th>
                    <th class="p-2">Statut</th>
                    <th class="p-2">Date</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="border-b dark:border-gray-700">
                    <td class="p-2">001</td>
                    <td class="p-2">Laptop XYZ</td>
                    <td class="p-2">En stock</td>
                    <td class="p-2">2025-07-01</td>
                  </tr>
                  <tr class="bg-green-50 dark:bg-gray-600 border-b dark:border-gray-700">
                    <td class="p-2">002</td>
                    <td class="p-2">Smartphone ABC</td>
                    <td class="p-2">Expédié</td>
                    <td class="p-2">2025-06-28</td>
                  </tr>
                  <tr class="border-b dark:border-gray-700">
                    <td class="p-2">003</td>
                    <td class="p-2">Écouteurs Pro</td>
                    <td class="p-2">En commande</td>
                    <td class="p-2">2025-07-05</td>
                  </tr>
                  <tr class="bg-green-50 dark:bg-gray-600 border-b dark:border-gray-700">
                    <td class="p-2">004</td>
                    <td class="p-2">Clavier Mécanique</td>
                    <td class="p-2">En stock</td>
                    <td class="p-2">2025-07-03</td>
                  </tr>
                  <tr>
                    <td class="p-2">005</td>
                    <td class="p-2">Souris Ergonomique</td>
                    <td class="p-2">Livré</td>
                    <td class="p-2">2025-06-25</td>
                  </tr>
                  </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <footer class="fixed bottom-0 left-0 w-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-center text-sm p-2 shadow-inner z-50">
    <p>&copy; 2025 Mon Dashboard. Tous droits réservés.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" defer></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script>
    // Fonction pour appliquer le mode (inchangée)
    function applyTheme(theme) {
      if (theme === 'dark') {
        document.documentElement.classList.add('dark');
      } else {
        document.documentElement.classList.remove('dark');
      }
    }

    // Fonction pour basculer le mode et l'enregistrer (inchangée)
    function toggleDarkMode() {
      if (document.documentElement.classList.contains('dark')) {
        applyTheme('light');
        localStorage.setItem('theme', 'light');
      } else {
        applyTheme('dark');
        localStorage.setItem('theme', 'dark');
      }
    }

    // Au chargement du DOM, vérifier le localStorage pour la préférence (inchangée)
    document.addEventListener("DOMContentLoaded", function () {
      const savedTheme = localStorage.getItem('theme');
      if (savedTheme) {
        applyTheme(savedTheme);
      } 

      // Init DataTable pour le tableau (inchangé)
      const dataTableExample = document.querySelector("#dataTableExample");
      if (dataTableExample) {
        new simpleDatatables.DataTable(dataTableExample, {
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

      // NOUVEAU : Initialisation de Select2
      // Utilisez jQuery pour sélectionner les éléments et appliquer Select2
      $('.select2-enable').select2({
        placeholder: "Rechercher ou sélectionner...", // Texte du placeholder
        allowClear: true // Permet de vider la sélection
      });

      // Menu profil (inchangé)
      const profileBtn = document.getElementById('profileBtn');
      const profileMenu = document.getElementById('profileMenu');
      profileBtn.addEventListener('click', (e) => {
        e.stopPropagation(); 
        profileMenu.classList.toggle('hidden');
      });
      window.addEventListener('click', function (e) {
        if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
          profileMenu.classList.add('hidden');
        }
      });

      // Menu mobile (inchangé)
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