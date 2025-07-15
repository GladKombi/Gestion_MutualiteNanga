
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
        perPage: "Pages",
        noRows: "Aucune donnée trouvée",
        info: "Page 1 sur 1"
      }
    });
  });
  // Utilisez jQuery pour sélectionner les éléments et appliquer Select2
  $('.select2-enable').select2({
    placeholder: "Rechercher ou sélectionner...", // Texte du placeholder
    allowClear: true // Permet de vider la sélection
  });
</script>