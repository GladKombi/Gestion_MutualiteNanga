<?php
# Connexion à la BD
include '../connexion/connexion.php'; //
# Appel de la page qui fait les affichages
require_once('../models/select/select-Adhesion.php');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Adhesion</title>
    <?php require_once('style.php') ?>

</head>

<body class="bg-white dark:bg-gray-900 text-gray-800 dark:text-white flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <?php require_once('aside.php') ?>

    <div class="flex-1 flex flex-col">
        <!-- NAVBAR -->
        <header class="flex items-center justify-between bg-white dark:bg-gray-800 shadow px-4 py-3">
            <h2 class="text-lg font-semibold text-primary">Adhesion</h2>
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
            <!-- <a href="annee.php" class="mb-4 px-4 py-2 bg-primary text-white rounded">Nouvelle annee</a> -->
            <button onclick="openModal('modalAdhesion')" class="mb-4 px-4 py-2 bg-primary text-white rounded"> Paiement Adhesion</button>
            <?php
            if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])) { ?>
                <div class="w-full mt-3">
                    <div class="bg-blue-100 text-blue-800 p-3 rounded-md text-center">
                        <?= $_SESSION['msg'] ?>
                    </div>
                </div>
            <?php }
            #Cette ligne permet de vider la valeur qui se trouve dans la session message
            unset($_SESSION['msg']);
            if (isset($_GET["idadhesion"])) {

            ?>
                <div class="bg-white dark:bg-gray-800 p-6 rounded shadow mb-6">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow mb-6">
                        <h2 class="text-2xl mb-4 font-bold text-center"><?= $title ?></h2>
                        <form action="<?= $url ?>" method="POST" enctype="multipart/form-data">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block mb-1">Membre <span class="text-red-600"> *</span></label>
                                    <select name="membre" required class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:text-white">
                                        <?php while ($membre = $getMembreMod->fetch()) {
                                            if (isset($_GET["idadhesion"])) {
                                        ?>
                                                <option value="<?= $membre['id'] ?>" <?php if ($membre['id'] == $membreModif) echo 'selected'; ?>>
                                                    <?= $membre['nom'] . " " . $membre['postnom'] . " " . $membre['prenom'] ?>
                                                </option>
                                            <?php
                                            } else { ?>
                                                <option value="<?= $membre['id'] ?>">
                                                    <?= $membre['nom'] . " " . $membre['postnom'] . " " . $membre['prenom'] ?>
                                                </option>
                                        <?php
                                            }
                                        } ?>
                                    </select>
                                </div>
                                <div>
                                    <label class="block mb-1">Montant de la cotisation<span class="text-red-600"> *</span></label>
                                    <input type="text" name="montant" required class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:text-white" placeholder="Enter le postnom" <?php if (isset($_GET['idadhesion'])) { ?>value="<?= $tab['montant'] ?>" <?php } ?> />
                                </div>
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="button" onclick="closeModal('modalAdhesion')" class="px-4 py-2 rounded border dark:border-gray-400">Annuler</button>
                                <button type="submit" name="Valider" class="px-4 py-2 bg-blue-600 text-white rounded"><?= $btn?></button>
                            </div>
                        </form>
                    </div>

                </div>
            <?php
            } else {
            ?>

                <table id="userTable" class="table-auto w-full">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>ID Membre</th>
                            <th>Profil</th>
                            <th>Montant</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $num = 0;
                        while ($adhesion = $getData->fetch()) {
                            $num++;
                        ?>
                            <tr class="border-b dark:border-gray-700 <?= $num % 2 === 0 ? 'bg-green-50 dark:bg-gray-600' : '' ?>">
                                <td class="p-2"><?php echo $num ?></td>
                                <td class="p-2"><?php echo $adhesion["date"] ?></td>
                                <td class="p-2"><?php echo $adhesion["nom"] . " " . $adhesion["prenom"] . " " . $adhesion["postnom"]  ?></td>
                                <td class="p-2"><img src="../img/<?= $adhesion["photo"] ?>" alt="" class="w-11 h-11 rounded-full cursor-pointer"></td>
                                <td class="p-2"><?php echo $adhesion["montant"] ?></td>
                                <td class="flex gap-2 p-2">
                                    <a href="adhesion.php?idadhesion=<?= $adhesion["id"] ?>" class="text-blue-600 hover:text-blue-800" title="Modifier">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button onclick="openDeleteModal('<?= $adhesion['id'] ?>')" title="Supprimer" class="text-red-600 hover:text-red-800">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>


            <?php
            }
            ?>

        </main>
    </div>

    <!-- Modal Enregistrement de paiement frais d'ahdesion-->
    <div id="modalAdhesion" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md w-full max-w-2xl">
            <h2 class="text-xl font-bold mb-4 text-center">Reglement Frais d'adhesion</h2>
            <form action="<?= $Action ?>" method="POST">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block mb-1">Membre <span class="text-red-600"> *</span></label>
                        <select name="membre" required class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:text-white">
                            <?php while ($membre = $getMembre->fetch()) { ?>
                                <option value="<?= $membre['id'] ?>"><?= $membre['nom'] . " " . $membre['postnom'] . " " . $membre['prenom'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1">Montant de la cotisation<span class="text-red-600"> *</span></label>
                        <input type="text" name="montant" required class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:text-white" placeholder="Enter le postnom" />
                    </div>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal('modalAdhesion')" class="px-4 py-2 rounded border dark:border-gray-400">Annuler</button>
                    <button type="submit" name="Valider" class="px-4 py-2 bg-blue-600 text-white rounded">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Suppression -->
    <div id="modalDelete" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[100] hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl max-w-sm w-full text-center">
            <h3 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Confirmer la suppression</h3>
            <p class="mb-6 text-gray-700 dark:text-gray-300">Êtes-vous sûr de vouloir supprimer cet élément ? Cette action est irréversible.</p>

            <p class="hidden">ID à supprimer : <span id="deleteIdDisplay" class="font-bold"></span></p>
            <input type="hidden" id="hiddenDeleteId" value="">

            <div class="flex justify-center gap-4">
                <button onclick="closeModal('modalDelete')" class="px-5 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-400 dark:hover:bg-gray-600 transition duration-150">Annuler</button>
                <a id="confirmDeleteButton" href="#" class="px-5 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-150">Supprimer</a>
            </div>
        </div>
    </div>
    <script>
        // Fonction pour ouvrir un modal et passer un ID
        function openDeleteModal(id) {
            const modal = document.getElementById('modalDelete');
            const confirmButton = document.getElementById('confirmDeleteButton');
            const deleteIdDisplay = document.getElementById('deleteIdDisplay');
            const hiddenDeleteId = document.getElementById('hiddenDeleteId');

            // Mettre à jour l'ID affiché et l'ID dans le champ caché
            deleteIdDisplay.textContent = id;
            hiddenDeleteId.value = id;

            // Définir le lien de suppression. Adaptez l'URL selon votre backend (ex: delete_membre.php?id=...)
            confirmButton.href = `../models/delete/delete_Adhesion.php?id=${id}`; // Assurez-vous que votre script de suppression gère cet ID

            modal.classList.remove('hidden'); // Afficher le modal
            document.body.classList.add('overflow-hidden'); // Empêcher le défilement du corps
        }

        // Fonction générique pour fermer un modal
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden'); // Cacher le modal
                document.body.classList.remove('overflow-hidden'); // Réactiver le défilement du corps
            }
        }
    </script>
    <?php require_once('script.php') ?>
</body>

</html>