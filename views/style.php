<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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
  if (localStorage.getItem("theme") === "dark") document.documentElement.classList.add("dark");
</script>
<style>
  .dataTable-wrapper .dataTable-input,
  .dataTable-wrapper .dataTable-selector {
    @apply px-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white;
  }

  .dataTable-wrapper .dataTable-pagination {
    @apply mt-6 flex justify-center gap-2 flex-wrap;
  }

  .dataTable-wrapper .dataTable-pagination a {
    @apply px-3 py-1 text-sm rounded border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-white hover:bg-primary hover:text-white;
  }

  .dataTable-wrapper .dataTable-pagination .active a {
    @apply bg-primary text-white border-primary;
  }

  table.dataTable thead {
    @apply bg-primary text-white;
  }

  table.dataTable td,
  table.dataTable th {
    @apply px-4 py-2;
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">