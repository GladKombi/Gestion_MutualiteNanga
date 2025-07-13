<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard avec Modals</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" />
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            primary: '#1D4ED8'
          }
        }
      }
    };
    if (localStorage.getItem("theme") === "dark") {
      document.documentElement.classList.add("dark");
    }
  </script>
  <style>
    .dataTable-wrapper .dataTable-input,
    .dataTable-wrapper .dataTable-selector {
      @apply px-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-primary focus:outline-none;
    }
    .dataTable-wrapper .dataTable-pagination {
      @apply mt-6 flex justify-center gap-2 flex-wrap;
    }
    .dataTable-wrapper .dataTable-pagination a {
      @apply px-3 py-1 text-sm rounded-md border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-white hover:bg-primary hover:text-white transition;
    }
    .dataTable-wrapper .dataTable-pagination .active a {
      @apply bg-primary text-white border-primary;
    }
    table.dataTable thead {
      @apply bg-primary text-white;
    }
    table.dataTable td, table.dataTable th {
      @apply px-4 py-2;
    }
  </style>
</head>
<body class="bg-white dark:bg-gray-900 text-gray-800 dark:text-white flex h-screen overflow-hidden">

  <!-- SIDEBAR -->
  <aside class="w-64 bg-white dark:bg-gray-800 hidden md:block shadow-md">
    <div class="p-6">
      <h1 class="text-xl font-bold text-primary">MonLogo</h1>
    </div>
    <nav class="px-4">
      <ul class="space-y-2">
        <li>
          <a href="#" class="flex items-center p-2 text-gray-700 dark:text-white hover:bg-blue-100 dark:hover:bg-gray-700 rounded">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6m-6 0H5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Dashboard
          </a>
        </li>
      </ul>
    </nav>
  </aside>

  <div class="flex-1 flex flex-col">
    <!-- NAVBAR -->
    <header class="flex items-center justify-between bg-white dark:bg-gray-800 shadow px-4 py-3">
      <h2 class="text-lg font-semibold text-primary">Tableau de bord</h2>
      <div class="flex items-center gap-4">
        <button onclick="toggleDarkMode()" class="text-gray-600 dark:text-white">
          <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 2a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 2zM10 14a4 4 0 100-8 4 4 0 000 8zm0 1.25a5.25 5.25 0 110-10.5 5.25 5.25 0 010 10.5z" />
          </svg>
        </button>
        <img src="https://i.pravatar.cc/40" class="w-8 h-8 rounded-full" />
      </div>
    </header>

    <!-- MAIN -->
    <main class="p-4">
      <button onclick="openModal('modalEdit')" class="mb-4 px-4 py-2 bg-primary text-white rounded">Ajouter un utilisateur</button>
      <table id="userTable" class="table-auto w-full">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Alice Dupont</td>
            <td>alice@example.com</td>
            <td>Admin</td>
            <td class="flex gap-2">
              <button onclick="openModal('modalEdit')" title="Modifier" class="text-blue-600 hover:text-blue-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M4 20h4.586a1 1 0 00.707-.293l10.586-10.586a1 1 0 000-1.414l-3.536-3.536a1 1 0 00-1.414 0L4 15.414V20z" />
                </svg>
              </button>
              <button onclick="openModal('modalDelete')" title="Supprimer" class="text-red-600 hover:text-red-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0a2 2 0 00-2-2H9a2 2 0 00-2 2h10z" />
                </svg>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </main>
  </div>

  <!-- Modal Modification -->
  <div id="modalEdit" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md w-full max-w-md">
      <h2 class="text-xl font-bold mb-4">Modifier l'utilisateur</h2>
      <form>
        <div class="mb-4">
          <label class="block mb-1">Nom</label>
          <input type="text" class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:text-white" />
        </div>
        <div class="mb-4">
          <label class="block mb-1">Email</label>
          <input type="email" class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:text-white" />
        </div>
        <div class="flex justify-end gap-2">
          <button type="button" onclick="closeModal('modalEdit')" class="px-4 py-2 rounded border dark:border-gray-400">Annuler</button>
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Suppression -->
  <div id="modalDelete" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md w-full max-w-sm">
      <h2 class="text-lg font-bold mb-4">Supprimer l'utilisateur</h2>
      <p>Êtes-vous sûr de vouloir supprimer cet utilisateur ?</p>
      <div class="flex justify-end gap-2 mt-6">
        <button onclick="closeModal('modalDelete')" class="px-4 py-2 rounded border dark:border-gray-400">Annuler</button>
        <button class="px-4 py-2 bg-red-600 text-white rounded">Supprimer</button>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" defer></script>
  <script>
    function toggleDarkMode() {
      const html = document.documentElement;
      html.classList.toggle('dark');
      localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
    }

    function openModal(id) {
      document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
      document.getElementById(id).classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', () => {
      new simpleDatatables.DataTable("#userTable", {
        perPage: 5,
        labels: {
          placeholder: "Rechercher...",
          perPage: "Afficher _MENU_ lignes",
          noRows: "Aucune donnée trouvée",
          info: "Page _PAGE_ sur _PAGES_"
        }
      });
    });
  </script>
</body>
</html>
