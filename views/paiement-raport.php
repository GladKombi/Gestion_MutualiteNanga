<?php

# Connexion à la BD
include '../connexion/connexion.php';

// Variables de filtres initiales
$filter_date = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';
$filter_cotisation = isset($_GET['filter_cotisation']) ? $_GET['filter_cotisation'] : '';
$filter_membre = isset($_GET['filter_membre']) ? $_GET['filter_membre'] : '';

// 1. Construction de la requête SQL de base
$sql = "SELECT 
            paiement.id,
            paiement.date AS datePaiement,
            membre.nom,
            membre.postnom,
            membre.prenom,
            membre.photo,
            cotisation.description AS nomCotisation,
            cotisation.montant AS montant_du,
            paiement.montant AS montantPaye
        FROM
            membre, cotisation, adhesion, paiement
        WHERE
            membre.id = adhesion.membre
            AND adhesion.id = paiement.adhesion
            AND cotisation.id = paiement.cotisation";

// 2. Ajout des conditions de filtre
$conditions = [];
$params = [];

// Filtre par date d'aujourd'hui
if ($filter_date === 'today') {
    $conditions[] = "DATE(paiement.date) = CURDATE()";
}

// Filtre par type de cotisation
if (!empty($filter_cotisation) && is_numeric($filter_cotisation)) {
    $conditions[] = "cotisation.id = :cotisation_id";
    $params[':cotisation_id'] = $filter_cotisation;
}

// Filtre par membre
if (!empty($filter_membre) && is_numeric($filter_membre)) {
    $conditions[] = "membre.id = :membre_id";
    $params[':membre_id'] = $filter_membre;
}

// Ajout des conditions à la requête SQL
if (!empty($conditions)) {
    $sql .= " AND " . implode(" AND ", $conditions);
}

$sql .= " ORDER BY paiement.date DESC";

// 3. Préparation et exécution de la requête principale
$stmt = $connexion->prepare($sql);
$stmt->execute($params);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);


// 4. Récupération des listes pour les filtres (avec PDO)
$cotisations_stmt = $connexion->query("SELECT id, description FROM cotisation ORDER BY description");
$cotisations = $cotisations_stmt->fetchAll(PDO::FETCH_ASSOC);

$membres_stmt = $connexion->query("SELECT id, nom, prenom, postnom FROM membre ORDER BY nom");
$membres = $membres_stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport de Paiements</title>
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

    <div class="bg-white p-6 rounded-lg shadow-md mb-6 no-print">
        <h2 class="text-xl font-bold mb-4">Filtrer les paiements</h2>
        <form method="GET" action="paiement-raport.php">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label for="filter_date" class="block text-sm font-medium text-gray-700">Date</label>
                    <select id="filter_date" name="filter_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-mwiraGreen-DEFAULT focus:ring-mwiraGreen-DEFAULT">
                        <option value="">Tous</option>
                        <option value="today" <?= ($filter_date === 'today' ? 'selected' : '') ?>>Aujourd'hui</option>
                    </select>
                </div>
                <div>
                    <label for="filter_cotisation" class="block text-sm font-medium text-gray-700">Type de Cotisation</label>
                    <select id="filter_cotisation" name="filter_cotisation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-mwiraGreen-DEFAULT focus:ring-mwiraGreen-DEFAULT">
                        <option value="">Tous</option>
                        <?php foreach ($cotisations as $cotisation) : ?>
                            <option value="<?= $cotisation['id'] ?>" <?= ($filter_cotisation == $cotisation['id'] ? 'selected' : '') ?>>
                                <?= htmlspecialchars($cotisation['description']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="filter_membre" class="block text-sm font-medium text-gray-700">Membre</label>
                    <select id="filter_membre" name="filter_membre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-mwiraGreen-DEFAULT focus:ring-mwiraGreen-DEFAULT">
                        <option value="">Tous</option>
                        <?php foreach ($membres as $membre) : ?>
                            <option value="<?= $membre['id'] ?>" <?= ($filter_membre == $membre['id'] ? 'selected' : '') ?>>
                                <?= htmlspecialchars($membre['nom'] . " " . $membre['prenom'] . " " . $membre['postnom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <button type="submit" class="w-full bg-mwiraGreen-dark text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200 shadow-md">
                        Filtrer
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="flex flex-col md:flex-row justify-end gap-4 mb-6 no-print">
        <a href="home.php" class="bg-mwiraRed-dark text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200 shadow-md w-full md:w-auto text-center">Quitter</a>
        <button onclick="window.print()" class="bg-mwiraGreen-dark text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200 shadow-md w-full md:w-auto flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 10H4a2 2 0 00-2 2v5a2 2 0 002 2h16a2 2 0 002-2v-5a2 2 0 00-2-2h-2m-6 0V3m0 0L9 6m3-3l3 3m6 7v3l-3 3H3l-3-3v-3a2 2 0 002-2h16a2 2 0 002 2z"></path>
            </svg>
            Imprimer
        </button>
    </div>

    <div id="invoice" class="bg-mwiraGray-light p-6 md:p-8 rounded-lg shadow-xl border border-gray-200">
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
        <h3 class="text-xl md:text-2xl font-bold text-center text-gray-900 mb-6">Rapport de paiements</h3>
        <div class="mb-8 overflow-x-auto">
            
            <table class="w-full border-2 border-black border-collapse text-sm">
                <thead>
                    <tr>
                        <th class="border-2 border-black px-4 py-2 text-left bg-gray-100 font-semibold">N°</th>
                        <th class="border-2 border-black px-4 py-2 text-left bg-gray-100 font-semibold">Date</th>
                        <th class="border-2 border-black px-4 py-2 text-left bg-gray-100 font-semibold">Membre</th>
                        <th class="border-2 border-black px-4 py-2 text-left bg-gray-100 font-semibold">Type cotisation</th>
                        <th class="border-2 border-black px-4 py-2 text-left bg-gray-100 font-semibold">Montant Payé</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $numero = 0;
                    $total_paye = 0;
                    if ($result) {
                        foreach ($result as $paiement) {
                            $numero += 1;
                            $total_paye += $paiement["montantPaye"];
                    ?>
                            <tr>
                                <td class="border-2 border-black px-4 py-2"><?= $numero; ?></td>
                                <td class="border-2 border-black px-4 py-2"><?= htmlspecialchars($paiement["datePaiement"]); ?></td>
                                <td class="border-2 border-black px-4 py-2"><?= htmlspecialchars($paiement["nom"] . " " . $paiement["postnom"] . " " . $paiement["prenom"]); ?></td>
                                <td class="border-2 border-black px-4 py-2"><?= htmlspecialchars($paiement["nomCotisation"]); ?></td>
                                <td class="border-2 border-black px-4 py-2"><?= htmlspecialchars($paiement["montantPaye"]); ?> $</td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td class="border-2 border-black px-4 py-2 text-center" colspan="5">Aucun paiement trouvé pour les critères de recherche.</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="border-2 border-black px-4 py-2 text-center font-bold" colspan="4">Total des paiements</td>
                        <td class="border-2 border-black px-4 py-2 font-bold"><?= number_format($total_paye, 2); ?> $</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

</body>
</html>