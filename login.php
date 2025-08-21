<?php
session_start();

// -- Changement de thème (cookie) --
if (isset($_POST['theme'])) {
    setcookie('theme', $_POST['theme'], time() + (3600 * 24 * 30), "/");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// -- Lecture du thème --
$theme = $_COOKIE['theme'] ?? 'light';

if(isset($_GET['fonction'])){
    $fonction=$_GET['fonction'];
}

?>
<!DOCTYPE html>
<html lang="fr" class="<?= $theme === 'dark' ? 'dark' : '' ?>">

<head>
    <meta charset="UTF-8" />
    <title>Connexion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white min-h-screen flex items-center justify-center relative">

    <!-- Bouton switch thème -->
    <form method="post" class="absolute top-4 right-4 z-50">
        <button name="theme" value="<?= $theme === 'dark' ? 'light' : 'dark' ?>"
            class="w-10 h-10 flex items-center justify-center rounded-full
           bg-gray-200 text-gray-700 hover:bg-gray-300 shadow-md
           dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 transition-all duration-300"
            title="Changer de thème">

            <?php if ($theme === 'dark'): ?>
                <!-- Soleil -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4V2m0 20v-2m4.22-13.78l1.42-1.42M4.93 19.07l1.42-1.42M20 12h2M2 12h2m13.78 4.22l1.42 1.42M4.93 4.93l1.42 1.42M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            <?php else: ?>
                <!-- Lune -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 12.79A9 9 0 1111.21 3a7 7 0 0010.59 9.79z" />
                </svg>
            <?php endif; ?>
        </button>
    </form>


    <!-- Carte connexion -->
    <div class="flex w-full max-w-5xl shadow-lg bg-white dark:bg-gray-800 rounded-lg overflow-hidden">

        <!-- Section logo -->
        <div class="hidden md:flex flex-col justify-center items-center bg-blue-600 dark:bg-blue-700 text-white w-1/2 p-8">
            <img src="https://upload.wikimedia.org/wikipedia/commons/a/ab/Logo_Tailwind_CSS.svg" alt="Logo"
                class="w-20 h-20 mb-6" />
            <h2 class="text-2xl font-bold mb-2">Bienvenue !</h2>
            <p class="text-sm text-blue-100 text-center px-6">Connecte-toi pour accéder à ton espace personnel.</p>
        </div>

        <!-- Formulaire -->
        <div class="w-full md:w-1/2 p-8">
            <h2 class="text-2xl font-semibold text-center mb-6">Connexion</h2>

            <!-- <?php if ($error): ?>
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?> -->

            <form action="models/login.php?fonction=<?=$fonction?>" method="post" class="space-y-5">
                <!-- Email -->
                <div>
                    <label for="email" class="block mb-1 text-sm font-medium">Adresse e-mail ou nom d'utilisateur</label>
                    <div class="flex items-center border border-gray-300 dark:border-gray-700 rounded px-3 py-2 bg-gray-50 dark:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 dark:text-gray-300 mr-2"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 12H8m0 0l4-4m-4 4l4 4" />
                        </svg>
                        <input type="text" name="username" id="email" required
                            class="w-full bg-transparent outline-none text-gray-900 dark:text-white placeholder-gray-400"
                            placeholder="ex: username" />
                    </div>
                </div>

                <!-- Mot de passe -->
                <div>
                    <label for="password" class="block mb-1 text-sm font-medium">Mot de passe</label>
                    <div class="flex items-center border border-gray-300 dark:border-gray-700 rounded px-3 py-2 bg-gray-50 dark:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 dark:text-gray-300 mr-2"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3zm0 0v1m0 4v.01" />
                        </svg>
                        <input type="password" name="password" id="password" required
                            class="w-full bg-transparent outline-none text-gray-900 dark:text-white placeholder-gray-400"
                            placeholder="••••••••" />
                    </div>
                </div>

                <!-- Bouton connexion -->
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded" name="connect">
                    Se connecter
                </button>
            </form>

            <p class="text-center mt-4 text-sm text-gray-600 dark:text-gray-400">
                Mot de passe oublié ? <a href="#" class="text-blue-600 hover:underline">Réinitialiser</a>
            </p>
        </div>
    </div>
</body>

</html>