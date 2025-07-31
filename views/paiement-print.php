<?php
# Connexion à la BD
include '../connexion/connexion.php';
if (isset($_GET['idPaiement'])) {
    $idPaiement = $_GET['idPaiement'];

} else {
    $_SESSION['msg'] = "ID de paiement manquant.";
    header("location: paiement.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Situation Paiement</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Couleurs personnalisées pour la cohérence de la marque Mwira_Trans
                        mwiraGreen: {
                            light: '#D1FAE5',
                            DEFAULT: '#15803D', // Un vert profond (similaire à green-700)
                            dark: '#065F46', // Un vert plus foncé
                        },
                        mwiraRed: { // Pour le bouton 'Quitter'
                            DEFAULT: '#DC2626', // Rouge-600 de Tailwind
                            dark: '#B91C1C', // Rouge-700 de Tailwind
                        },
                        mwiraGray: { // Pour le fond similaire à la classe 'fon' d'origine
                            light: '#F3F4F6', // gris-100
                            DEFAULT: '#E5E7EB', // gris-200
                            dark: '#1F2937', // gris-800
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Styles d'impression personnalisés pour surcharger Tailwind si nécessaire */
        @media print {
            .no-print {
                display: none !important;
            }

            /* Assurer des bordures visibles pour l'impression, ajustez 2px si 5px est impératif */
            table,
            th,
            td {
                border: 2px solid black !important;
                /* Plus commun pour l'impression que 5px */
                border-collapse: collapse !important;
            }

            /* Forcer le texte en noir pour une meilleure lisibilité à l'impression */
            body,
            h1,
            h2,
            h3,
            h4,
            h5,
            h6,
            p,
            span,
            div,
            a {
                color: #000 !important;
            }

            /* Supprimer les couleurs de fond pour économiser l'encre */
            .bg-mwiraGreen-DEFAULT,
            .bg-mwiraGray-light,
            .bg-white {
                background-color: transparent !important;
            }

            /* Supprimer les ombres pour l'impression */
            .shadow-xl,
            .shadow-lg,
            .shadow-md {
                box-shadow: none !important;
            }

            /* Assurer que la page s'imprime correctement */
            html,
            body {
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
            <a href="paiement.php" class="bg-mwiraRed-dark text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200 shadow-md w-full md:w-auto text-center">Quitter</a>
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
                        <?php $date = date('d/m/Y');
                        echo $date; ?>
                    </h5>
                </div>
            </div>
            <h3 class="text-xl md:text-2xl font-bold text-center text-gray-900 mb-6">Recu de paiement</h3>
            <div class="mb-8 overflow-x-auto">
                
                <table class="w-full border-2 border-black border-collapse text-sm">
                    <thead>
                        <tr>
                            <th class="border-2 border-black px-4 py-2 text-left bg-gray-100 font-semibold">N°</th>
                            <th class="border-2 border-black px-4 py-2 text-left bg-gray-100 font-semibold">Date</th>
                            <th class="border-2 border-black px-4 py-2 text-left bg-gray-100 font-semibold">ID Employer</th>
                            <th class="border-2 border-black px-4 py-2 text-left bg-gray-100 font-semibold">Profil</th>
                            <th class="border-2 border-black px-4 py-2 text-left bg-gray-100 font-semibold">Type cotisation</th>
                            <th class="border-2 border-black px-4 py-2 text-left bg-gray-100 font-semibold">Montant Du</th>
                            <th class="border-2 border-black px-4 py-2 text-left bg-gray-100 font-semibold">Montant Payé</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $statut = 0;
                        $cloture = 0;
                        $affichercat = $connexion->prepare("SELECT membre.*, paiement.id, paiement.date as datePaiement, cotisation.description as nomCotisation, cotisation.montant as montant_du, SUM(paiement.montant) as montantPaye, cotisation.montant-SUM(paiement.montant) as montantRestant FROM membre, cotisation, adhesion, paiement WHERE membre.id=adhesion.membre AND adhesion.id=paiement.adhesion AND cotisation.id=paiement.cotisation AND paiement.statut=? AND paiement.id=?;");
                        $affichercat->execute(array($statut, $idPaiement));
                        $numero = 0;
                        while ($tab = $affichercat->fetch()) {
                            $numero += 1;
                        ?>
                            <tr>
                                <td class="border-2 border-black px-4 py-2"><?php echo $numero; ?></td>
                                <td class="border-2 border-black px-4 py-2"><?php echo $tab["datePaiement"]; ?></td>
                                <td class="border-2 border-black px-4 py-2"><?php echo $tab["nom"] . " " . $tab["postnom"] . " " . $tab["prenom"]; ?></td>
                                <td class="border-2 border-black px-4 py-2">
                                    <img src="../img/<?= $tab["photo"] ?>" alt="" class="w-11 h-11 rounded-full cursor-pointer">
                                </td>
                                <td class="border-2 border-black px-4 py-2"><?php echo $tab["nomCotisation"]; ?></td>
                                <td class="border-2 border-black px-4 py-2"><?php echo $tab["montant_du"]; ?> $</td>
                                <td class="border-2 border-black px-4 py-2"><?php echo $tab["montantPaye"]; ?> $</td>
                            </tr>
                            <tr>
                                <td class="border-2 border-black px-4 py-2 text-center" colspan="6" ><b >Montant Restant</b> </td>
                                <td class="border-2 border-black px-4 py-2"><b><?php echo $tab["montantRestant"]; ?> $</b></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

           
        </div>
    </div>

    <script>
        // Le code JavaScript pour saveAsImage() dépend de la bibliothèque html2canvas.
        // Si vous avez besoin de cette fonctionnalité, assurez-vous que html2canvas est chargé.
        // function saveAsImage() {
        //     const invoiceElement = document.getElementById('invoice');
        //     html2canvas(invoiceElement).then(canvas => {
        //         const link = document.createElement('a');
        //         link.download = 'facture.png';
        //         link.href = canvas.toDataURL('image/png'); // Type MIME corrigé
        //         link.click();
        //     });
        // }
    </script>
</body>

</html>