<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Association des Jeunes Solidaire</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            transition: background-color 0.3s, color 0.3s;
        }

        .slider {
            position: relative;
            overflow: hidden;
            height: 400px;
        }

        .slide {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .active {
            opacity: 1;
        }

        .slide-content {
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
        }

        .button {
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }
    </style>
</head>

<body class="bg-white text-gray-800 dark:bg-gray-800 dark:text-gray-200">

    <!-- En-tête -->
    <header class="bg-blue-600 text-white">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Association des Jeunes</h1>
            <div class="relative">
                <nav>
                    <ul class="flex space-x-4">
                        <li><a href="#presentation" class="hover:underline">Présentation</a></li>
                        <li><a href="#services" class="hover:underline">Nos Services</a></li>
                        <li><a href="#news" class="hover:underline">Nouvelles</a></li>
                        <li><a href="#contact" class="hover:underline">Contact</a></li>
                        <li class="relative">
                            <button id="dropdownButton" class="hover:underline focus:outline-none">Connexion</button>
                            <div id="dropdownMenu" class="absolute right-0 z-10 hidden bg-white text-gray-800 shadow-lg mt-2 rounded">
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Se connecter</a>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">S'inscrire</a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <button id="theme-toggle" class="text-white ml-4">
                    <svg id="theme-toggle-dark-icon" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Section de bienvenue avec slider -->
    <section id="presentation" class="py-10">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-4">Bienvenue à notre Association</h2>
            <div class="slider">
                <div class="slide active" style="background-image: url('img/img1.jpg'); background-size: cover; background-position: center;">
                    <div class="slide-content">
                        <h3 class="text-xl font-bold">Épanouissement Personnel</h3>
                        <p>Rejoignez-nous pour développer vos compétences et talents.</p>
                    </div>
                </div>
                <div class="slide" style="background-image: url('img/img3.jpg'); background-size: cover; background-position: center;">
                    <div class="slide-content">
                        <h3 class="text-xl font-bold">Solidarité et Entraide</h3>
                        <p>Un espace pour partager et se soutenir mutuellement.</p>
                    </div>
                </div>
                <div class="slide" style="background-image: url('img/img2.jpg'); background-size: cover; background-position: center;">
                    <div class="slide-content">
                        <h3 class="text-xl font-bold">Événements Sociaux</h3>
                        <p>Participez à des événements et rencontrez d'autres jeunes.</p>
                    </div>
                </div>
            </div>
            <div class="flex justify-between mt-4">
                <button class="button" onclick="prevSlide()">❮</button>
                <button class="button" onclick="nextSlide()">❯</button>
            </div>
            <div class="flex justify-center mt-6">
                <a href="#services" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Découvrez nos activités</a>
            </div>
        </div>
    </section>

    <!-- Section des services -->
    <section id="services" class="bg-white py-10">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-6">Nos Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-200 p-4 rounded-lg shadow">
                    <h3 class="font-semibold text-lg">Ateliers de Formation</h3>
                    <p>Des formations variées pour développer vos compétences et vos talents.</p>
                    <img src="img/img1.jpg" alt="Ateliers de Formation" class="mt-2 rounded">
                </div>
                <div class="bg-gray-200 p-4 rounded-lg shadow">
                    <h3 class="font-semibold text-lg">Événements Sociaux</h3>
                    <p>Participez à des événements pour rencontrer d'autres jeunes et créer des liens.</p>
                    <img src="img/img3.jpg" alt="Événements Sociaux" class="mt-2 rounded">
                </div>
                <div class="bg-gray-200 p-4 rounded-lg shadow">
                    <h3 class="font-semibold text-lg">Soutien Psychologique</h3>
                    <p>Des services d'écoute et de soutien pour traverser les moments difficiles.</p>
                    <img src="img/img2.jpg" alt="Soutien Psychologique" class="mt-2 rounded">
                </div>
            </div>
        </div>
    </section>

    <!-- Section des nouvelles -->
    <section id="news" class="bg-gray-100 py-10">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-6">Nouvelles de l'Association</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-4 rounded-lg shadow">
                    <img src="img/img3.jpg" alt="Activité 1" class="rounded mb-2">
                    <h3 class="font-semibold text-lg">Atelier de Création Artistique</h3>
                    <p>Rejoignez-nous pour un atelier où vous pourrez exprimer votre créativité à travers l'art.</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <img src="img/img2.jpg" alt="Activité 2" class="rounded mb-2">
                    <h3 class="font-semibold text-lg">Journée de Nettoyage</h3>
                    <p>Participez à notre journée de nettoyage pour faire une différence dans notre communauté.</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <img src="img/img1.jpg" alt="Activité 3" class="rounded mb-2">
                    <h3 class="font-semibold text-lg">Soirée de Jeux</h3>
                    <p>Venez vous amuser lors de notre soirée de jeux et rencontrer d'autres membres de l'association.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section de contact -->
    <section id="contact" class="py-10">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-6">Contactez-nous</h2>
            <form class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow">
                <div class="mb-4">
                    <label class="block mb-2" for="name">Nom</label>
                    <input class="w-full p-2 border rounded" type="text" id="name" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-2" for="email">Email</label>
                    <input class="w-full p-2 border rounded" type="email" id="email" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-2" for="message">Message</label>
                    <textarea class="w-full p-2 border rounded" id="message" rows="4" required></textarea>
                </div>
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" type="submit">Envoyer</button>
            </form>
        </div>
    </section>

    <!-- Pied de page -->
    <footer class="bg-blue-600 text-white py-4">
        <div class="container mx-auto text-center">
            <p>&copy; 2023 Association des Jeunes. Tous droits réservés.</p>
        </div>
    </footer>

    <script>
        let currentIndex = 0;
        const slides = document.querySelectorAll('.slide');

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.remove('active');
                if (i === index) {
                    slide.classList.add('active');
                }
            });
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % slides.length;
            showSlide(currentIndex);
        }

        function prevSlide() {
            currentIndex = (currentIndex - 1 + slides.length) % slides.length;
            showSlide(currentIndex);
        }

        // Initial display
        showSlide(currentIndex);

        document.getElementById("theme-toggle").addEventListener("click", function() {
            document.body.classList.toggle("dark");
            const darkIcon = document.getElementById("theme-toggle-dark-icon");
            const lightIcon = document.getElementById("theme-toggle-light-icon");
            darkIcon.classList.toggle("hidden");
            lightIcon.classList.toggle("hidden");
        });

        // Dropdown menu
        document.getElementById("dropdownButton").addEventListener("click", function() {
            document.getElementById("dropdownMenu").classList.toggle("hidden");
        });

        window.onclick = function(event) {
            if (!event.target.matches('#dropdownButton')) {
                const dropdowns = document.getElementsByClassName("hidden");
                for (let i = 0; i < dropdowns.length; i++) {
                    dropdowns[i].classList.add('hidden');
                }
            }
        }
    </script>
</body>

</html>