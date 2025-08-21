<?php
# Connexion à la BD
include('../connexion/connexion.php');


// Configuration de l'adhésion
$adhesion_config = [
    'total_a_payer' => 10.00
];

# Démarrer la session si elle n'est pas déjà démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

# Récupérer les informations de l'utilisateur connecté
$idUser = $_SESSION['iduser'];
if (empty($idUser)) {
    header("location:../views/dashboard-membre.php");
    exit();
} else {
    $noms = $_SESSION['nom'] . " " . $_SESSION['postnom'] . " " . $_SESSION['prenom'];
    $photo = $_SESSION['photo'];
    $username = $_SESSION['email'];
    $addresse = $_SESSION['adresse'];

    // Vérifier si l'utilisateur existe dans la base de données
    $req = $connexion->prepare("SELECT * FROM membre WHERE id=?");
    $req->execute(array($idUser));
    $member = $req->fetch();
    if (!$member) {
        header("location:../views/dashboard-membre.php");
        exit();
    }
    # selection des paiements du membre
    $statut = 0;
    $getPaiement = $connexion->prepare("SELECT paiement.*, cotisation.description as nomCotisation, cotisation.montant as montant_du, SUM(paiement.montant) as montantPaye, cotisation.montant-SUM(paiement.montant) as montantRestant FROM `paiement`,adhesion,membre,cotisation WHERE paiement.adhesion=adhesion.id AND paiement.cotisation=cotisation.id AND paiement.statut=? AND adhesion.membre=?;");
    $getPaiement->execute([$statut, $idUser]);
    # Selection des touts les cotisations
    $getCotisation = $connexion->prepare("SELECT `cotisation`.*, type_cotisation.description as TypeDescription FROM `cotisation`,`type_cotisation` WHERE cotisation.type=type_cotisation.id AND cotisation.statut=?;");
    $getCotisation->execute([$statut]);
    // Selection de l'adhesion du membre pour vérification
    $req = $connexion->prepare("SELECT montant FROM adhesion WHERE membre=?");
    $req->execute(array($idUser));
    if ($AdhesionPaye = $req->fetch()) {
        $montantAdhesion = $AdhesionPaye['montant'];
    } else {
        $montantAdhesion = 0;
    }
    // Calcul du solde restant
    $solde = $adhesion_config['total_a_payer'] - $montantAdhesion;

    // Définir la classe de couleur en fonction du solde
    $solde_color_class = $solde > 0 ? 'text-red-600' : 'text-green-600';
}


// Récupérer et effacer les messages de la session
$message_type = isset($_SESSION['message_type']) ? $_SESSION['message_type'] : '';
$message_text = isset($_SESSION['message_text']) ? $_SESSION['message_text'] : '';
unset($_SESSION['message_type']);
unset($_SESSION['message_text']);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AJS_Butembo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        /* Custom modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 24px;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .profile-form-hidden {
            display: none;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm py-4 px-4 sm:px-6 lg:px-8 mb-8">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <a href="#" class="text-xl font-bold text-gray-900">Tableau de bord</a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="#" class="text-gray-600 hover:text-gray-900 font-medium transition-colors duration-200">Accueil</a>
                <a href="../models/log-out.php" class="text-gray-600 hover:text-gray-900 font-medium transition-colors duration-200">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto w-full p-4 flex-grow">
        <header class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">AJS_Butembo</h1>
            <p class="text-xl text-gray-600">Bienvenue, <span class="font-semibold"><?= htmlspecialchars($noms) ?></span> !</p>
        </header>

        <!-- Affichage des messages de succès/erreur -->
        <?php
        if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])) { ?>
            <div class="w-full mt-3">
                <div class="bg-blue-100 text-blue-800 p-3 rounded-md text-center mb-4">
                    <?= $_SESSION['msg'] ?>
                </div>
            </div>
        <?php }
        #Cette ligne permet de vider la valeur qui se trouve dans la session message
        unset($_SESSION['msg']);

        ?>

        <main class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            if (isset($_GET["selfPay"])) {
            ?>
                <div class="bg-white rounded-xl shadow-lg p-6 lg:col-span-2 border border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Les paiement en ligne sont suspendus pour l'instant</h2>
                    <div class="overflow-x-auto">
                        <button class="w-full bg-red-800 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-xl transition-colors duration-200">
                            <a href="dashboard-membre.php">Retour</a>
                        </button>
                    </div>
                </div>
            <?php
            } else {
            ?>
                <!-- Carte Gestion du profil (Affichage du profil) -->
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                    <div id="profile-display">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Mon profil</h2>
                        <div class="flex flex-col items-center mb-6">
                            <img src="../img/<?= htmlspecialchars($photo) ?>" alt="Photo de profil" class="w-24 h-24 rounded-full object-cover mb-4 border-2 border-gray-300">
                            <p class="text-xl font-bold text-gray-900"><?= htmlspecialchars($noms) ?></p>
                            <p class="text-gray-600">Utilisateur : <?= htmlspecialchars($username) ?></p>
                            <p class="text-gray-600">Adresse : <?= htmlspecialchars($addresse) ?></p>
                        </div>
                        <button onclick="toggleProfileForm()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition-colors duration-200">
                            Mettre à jour le profil
                        </button>
                    </div>

                    <!-- Formulaire de mise à jour du profil (masqué par défaut) -->
                    <div id="profile-form" class="profile-form-hidden">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Mise à jour du profil</h2>
                        <!-- Le formulaire envoie les données à un nouveau script PHP -->
                        <form action="../models/add/save_profile.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $member['id'] ?>">
                            <div class="flex items-center space-x-4 mb-6">
                                <img src="../img/<?= htmlspecialchars($photo) ?>" alt="Photo de profil" class="w-16 h-16 rounded-full object-cover border-2 border-gray-300">
                                <label class="cursor-pointer bg-gray-200 hover:bg-gray-300 transition-colors duration-200 text-gray-700 font-semibold py-2 px-4 rounded-full">
                                    Mettre à jour la photo
                                    <input type="file" name="profile_photo" class="hidden">
                                </label>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                                    <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($member['nom']) ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                                    <input type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($member['prenom']) ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="username" class="block text-sm font-medium text-gray-700">Nom d'utilisateur</label>
                                    <input type="text" name="username" id="username" value="<?= htmlspecialchars($member['email']) ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                                    <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <p class="mt-2 text-sm text-gray-500">Laissez vide pour ne pas changer de mot de passe.</p>
                                </div>
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-xl transition-colors duration-200 mt-4">
                                    Enregistrer
                                </button>
                                <button type="button" onclick="toggleProfileForm()" class="w-full bg-gray-400 hover:bg-gray-500 text-white font-bold py-3 px-6 rounded-xl transition-colors duration-200">
                                    Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Carte Adhésion et solde -->
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Statut de l'adhésion</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                            <span class="text-lg font-medium text-gray-600">Total à payer</span>
                            <span class="text-2xl font-bold text-gray-900"><?= number_format($adhesion_config['total_a_payer'], 2, ',', '.') ?> $</span>
                        </div>
                        <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                            <span class="text-lg font-medium text-gray-600">Montant déjà payé</span>
                            <span class="text-2xl font-bold text-green-600"><?= number_format($montantAdhesion, 2, ',', '.') ?> $</span>
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <span class="text-lg font-medium text-gray-600">Solde restant</span>
                            <span class="text-2xl font-bold <?= $solde_color_class ?>"><?= number_format($solde, 2, ',', '.') ?> $</span>
                        </div>
                    </div>
                </div>

                <!-- Carte Liste des cotisations -->
                <div class="bg-white rounded-xl shadow-lg p-6 lg:col-span-2 border border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Liste des cotisations</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Montant</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php
                                $num = 0;
                                $getCotisation->execute([$statut]);
                                while ($cotisation = $getCotisation->fetch(PDO::FETCH_ASSOC)) {
                                    $num++;
                                ?>
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $num ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($cotisation["date"]) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($cotisation["description"]) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($cotisation["TypeDescription"]) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= number_format($cotisation["montant"], 2, ',', '.') ?> $</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <!-- CORRECTION: Utilisation de la bonne variable $cotisation -->
                                            <button onclick="openPaymentModal(<?= htmlspecialchars($cotisation['montant']) ?>)" class="text-blue-600 hover:text-blue-900 transition-colors duration-200">
                                                Payer
                                            </button>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Carte Mes paiements -->
                <div class="bg-white rounded-xl shadow-lg p-6 lg:col-span-2 border border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Mes paiements</h2>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Montant Dû</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Montant Payé</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Montant restant</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php
                                $num = 0;
                                while ($paiement = $getPaiement->fetch()) {
                                    $num++;
                                ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= htmlspecialchars($num) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($paiement['date']); ?> $</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($paiement['nomCotisation']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= number_format($paiement['montant_du'], 2, ',', '.') ?> $</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= number_format($paiement['montantPaye'], 2, ',', '.') ?> $</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= number_format($paiement['montantRestant'], 2, ',', '.') ?> $</td>
                                    </tr>
                                <?php
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php
            }
            ?>

        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2024 Mon Organisation. Tous droits réservés.</p>
        </div>
    </footer>

    <!-- Modal de paiement -->
    <div id="paymentModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closePaymentModal()">&times;</span>
            <h3 class="text-xl font-bold mb-4">Formulaire de paiement</h3>
            <form id="paymentForm">
                <div class="mb-4">
                    <label for="payment_method" class="block text-sm font-medium text-gray-700">Mode de paiement</label>
                    <select id="payment_method" name="payment_method" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="airtelmoney">Airtel Money</option>
                        <option value="orangemoney">Orange Money</option>
                        <option value="mpesa">M-Pesa</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="payment_amount" class="block text-sm font-medium text-gray-700">Montant ($)</label>
                    <input type="number" step="0.01" id="payment_amount" name="payment_amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Numéro de téléphone</label>
                    <div class="flex items-center mt-1">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                            +243
                        </span>
                        <input type="text" id="phone_number" name="phone_number" placeholder="Entrez votre numéro" class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                <!-- <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-xl transition-colors duration-200">
                    Confirmer le paiement
                </button> -->
                <a href="dashboard-membre.php?selfPay" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-xl transition-colors duration-200">
                    Confirmer le paiement
                </a>
            </form>
        </div>
    </div>

    <script>
        let paymentModal = document.getElementById("paymentModal");
        let paymentAmountInput = document.getElementById("payment_amount");
        let profileDisplay = document.getElementById("profile-display");
        let profileForm = document.getElementById("profile-form");

        function openPaymentModal(amount) {
            paymentModal.style.display = "block";
            paymentAmountInput.value = amount; // Correction: enlever .toFixed(2) pour permettre une saisie plus flexible
        }

        function closePaymentModal() {
            paymentModal.style.display = "none";
        }

        function toggleProfileForm() {
            profileDisplay.classList.toggle('profile-form-hidden');
            profileForm.classList.toggle('profile-form-hidden');
        }

        // Le modal ne se ferme plus en cliquant en dehors
        // window.onclick = function(event) {
        //     if (event.target == paymentModal) {
        //         closePaymentModal();
        //     }
        // }
    </script>

</body>

</html>