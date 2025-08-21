<?php
# Connexion à la BD
include '../connexion/connexion.php';

// Requête SQL pour sélectionner les membres adhérents
// Le statut=0 est utilisé pour filtrer les membres dont l'adhésion est active
$sql = "SELECT adhesion.*, membre.nom, membre.postnom, membre.prenom, membre.photo FROM adhesion, membre WHERE adhesion.membre = membre.id AND adhesion.statut = 0";

try {
    // Préparation et exécution de la requête
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $adherents = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Gérer les erreurs de base de données
    $_SESSION['msg'] = "Erreur lors de la récupération des données : " . $e->getMessage();
    header("location: ../../views/dashboad-membre.php"); // Redirigez vers la page appropriée
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport des Membres Adhérents</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Couleurs personnalisées
                        mwiraGreen: {
                            light: '#D1FAE5',
                            DEFAULT: '#15803D',
                            dark: '#065F46',
                        },
                        mwiraRed: {
                            DEFAULT: '#DC2626',
                            dark: '#B91C1C',
                        },
                        mwiraGray: {
                            light: '#F3F4F6',
                            DEFAULT: '#E5E7EB',
                            dark: '#1F2937',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Styles d'impression personnalisés */
        @media print {
            .no-print {
                display: none !important;
            }
            table, th, td {
                border: 1px solid black !important;
                border-collapse: collapse !important;
            }
            body, h1, h2, h3, h4, h5, h6, p, span, div, a {
                color: #000 !important;
            }
            .bg-mwiraGreen-DEFAULT, .bg-mwiraGray-light, .bg-white {
                background-color: transparent !important;
            }
            .shadow-xl, .shadow-lg, .shadow-md {
                box-shadow: none !important;
            }
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }
            .container {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800">

<div class="container mx-auto px-4 py-6 mt-5">

    <div class="flex flex-col md:flex-row justify-end gap-4 mb-6 no-print">
        <a href="home.php" class="bg-mwiraRed-dark text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200 shadow-md w-full md:w-auto text-center">Quitter</a>
        <button onclick="window.print()" class="bg-mwiraGreen-dark text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200 shadow-md w-full md:w-auto flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 10H4a2 2 0 00-2 2v5a2 2 0 002 2h16a2 2 0 002-2v-5a2 2 0 00-2-2h-2m-6 0V3m0 0L9 6m3-3l3 3m6 7v3l-3 3H3l-3-3v-3a2 2 0 002-2h16a2 2 0 002 2z"></path>
            </svg>
            Imprimer
        </button>
    </div>

    <div id="report" class="bg-mwiraGray-light p-6 md:p-8 rounded-lg shadow-xl border border-gray-200">
        <div class="flex flex-col md:flex-row justify-between items-start mb-6">
            <div class="mb-4 md:mb-0">
                <h3 class="text-2xl font-bold text-gray-800">Jeune Solidaire Bbo</h3>
                <p class="text-gray-700">Q.Vuhira</p>
                <p class="text-gray-700">Cellule MCA, N° 1</p>
                <p class="text-gray-700">Tel : +243 000 000 000</p>
            </div>
            <div class="text-left md:text-right">
                <h5 class="text-gray-700">Bbo le
                    <?php echo date('d/m/Y'); ?>
                </h5>
            </div>
        </div>
        <h3 class="text-xl md:text-2xl font-bold text-center text-gray-900 mb-6">Liste des Membres Adhérents</h3>
        <div class="mb-8 overflow-x-auto">
            <table class="w-full border-2 border-black border-collapse text-sm">
                <thead>
                    <tr>
                        <th class="border-2 border-black px-4 py-2 text-left bg-gray-100 font-semibold">N°</th>
                        <th class="border-2 border-black px-4 py-2 text-left bg-gray-100 font-semibold">Photo</th>
                        <th class="border-2 border-black px-4 py-2 text-left bg-gray-100 font-semibold">Nom Complet</th>
                        <th class="border-2 border-black px-4 py-2 text-left bg-gray-100 font-semibold">ID Adhésion</th>
                        <th class="border-2 border-black px-4 py-2 text-left bg-gray-100 font-semibold">Date Adhésion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($adherents)) {
                        $numero = 0;
                        foreach ($adherents as $adherent) {
                            $numero += 1;
                    ?>
                            <tr>
                                <td class="border-2 border-black px-4 py-2"><?= $numero; ?></td>
                                <td class="border-2 border-black px-4 py-2">
                                    <img src="../img/<?= htmlspecialchars($adherent['photo']) ?>" alt="Photo de profil" class="w-11 h-11 rounded-full object-cover">
                                </td>
                                <td class="border-2 border-black px-4 py-2"><?= htmlspecialchars($adherent['nom'] . " " . $adherent['postnom'] . " " . $adherent['prenom']); ?></td>
                                <td class="border-2 border-black px-4 py-2"><?= htmlspecialchars($adherent['id']); ?></td>
                                <td class="border-2 border-black px-4 py-2"><?= htmlspecialchars($adherent['date']); ?></td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td class="border-2 border-black px-4 py-2 text-center" colspan="5">Aucun membre adhérent trouvé.</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>