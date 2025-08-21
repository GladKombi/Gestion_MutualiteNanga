<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Association des Jeunes Solidaire</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            transition: background-color 0.3s, color 0.3s;
        }

        .dark body {
            background-color: #1a202c;
            color: #e2e8f0;
        }

        .slider {
            position: relative;
            overflow: hidden;
            height: 450px;
        }

        .slide {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 0.7s ease-in-out;
        }

        .slide.active {
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
            background-color: rgba(0, 0, 0, 0.6);
            padding: 20px;
        }

        .button-nav {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 8px 16px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button-nav:hover {
            background-color: rgba(255, 255, 255, 0.4);
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 dark:bg-gray-900 dark:text-gray-100 font-sans">

    <header class="bg-blue-600 text-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="#" class="text-2xl md:text-3xl font-bold font-serif hover:text-blue-200 transition-colors">
                Association des Jeunes
            </a>
            
            <nav class="hidden md:flex items-center space-x-6">
                <a href="#about" class="hover:underline hover:text-blue-200 transition-colors">À propos</a>
                <a href="#services" class="hover:underline hover:text-blue-200 transition-colors">Nos Services</a>
                <a href="#news" class="hover:underline hover:text-blue-200 transition-colors">Nouvelles</a>
                <a href="#team" class="hover:underline hover:text-blue-200 transition-colors">Équipe</a>
                <a href="#contact" class="hover:underline hover:text-blue-200 transition-colors">Contact</a>
                <div class="relative group">
                    <button id="dropdownButton" class="hover:underline focus:outline-none">
                        Connexion
                        <svg class="h-4 w-4 inline-block ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div id="dropdownMenu" class="absolute right-0 z-10 hidden bg-white text-gray-800 shadow-lg mt-2 rounded-md transition-all duration-300 transform scale-95 opacity-0 group-hover:scale-100 group-hover:opacity-100 origin-top-right">
                        <a href="login.php?fonction=Admin" class="block px-4 py-2 hover:bg-gray-100 rounded-md">Administrateur</a>
                        <a href="login.php?fonction=president" class="block px-4 py-2 hover:bg-gray-100 rounded-md">President</a>
                        <a href="login.php?fonction=compte" class="block px-4 py-2 hover:bg-gray-100 rounded-md">Comptable</a>
                        <a href="login.php?fonction=membre" class="block px-4 py-2 hover:bg-gray-100 rounded-md">Membre</a>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 rounded-md">S'inscrire</a>
                    </div>
                </div>
                <button id="theme-toggle" class="text-white ml-4">
                    <svg id="theme-toggle-dark-icon" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path>
                    </svg>
                </button>
            </nav>
            
            <div class="flex items-center md:hidden">
                <button id="theme-toggle-mobile" class="text-white mr-4">
                    <svg id="theme-toggle-dark-icon-mobile" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon-mobile" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path>
                    </svg>
                </button>
                <button id="hamburger-button" class="text-white focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <nav id="mobile-menu" class="hidden md:hidden bg-blue-700 text-white text-center">
            <a href="#about" class="block py-2 hover:bg-blue-800 transition-colors">À propos</a>
            <a href="#services" class="block py-2 hover:bg-blue-800 transition-colors">Nos Services</a>
            <a href="#news" class="block py-2 hover:bg-blue-800 transition-colors">Nouvelles</a>
            <a href="#team" class="block py-2 hover:bg-blue-800 transition-colors">Équipe</a>
            <a href="#contact" class="block py-2 hover:bg-blue-800 transition-colors">Contact</a>
            <div class="py-2">
                <button class="w-full text-left px-4 py-2 hover:bg-blue-800 transition-colors">Connexion</button>
                <div class="bg-blue-600">
                    <a href="#" class="block px-8 py-2 hover:bg-blue-700 transition-colors">Se connecter</a>
                    <a href="#" class="block px-8 py-2 hover:bg-blue-700 transition-colors">S'inscrire</a>
                </div>
            </div>
        </nav>
    </header>

    <section id="presentation" class="py-16 md:py-24">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-4">Bienvenue à notre Association</h2>
            <p class="text-xl text-center mb-10 text-gray-600 dark:text-gray-300">
                Ensemble, construisons un avenir meilleur pour les jeunes.
            </p>
            <div class="slider rounded-xl shadow-lg">
                <div class="slide active" style="background-image: url('https://images.unsplash.com/photo-1549227546-2713f0a7114d?q=80&w=2940&auto=format&fit=crop'); background-size: cover; background-position: center;">
                    <div class="slide-content">
                        <h3 class="text-3xl font-bold drop-shadow-md">Épanouissement Personnel</h3>
                        <p class="mt-2 text-lg drop-shadow-md">Rejoignez-nous pour développer vos compétences et talents.</p>
                    </div>
                </div>
                <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1522204523234-8729aa6e993e?q=80&w=2940&auto=format&fit=crop'); background-size: cover; background-position: center;">
                    <div class="slide-content">
                        <h3 class="text-3xl font-bold drop-shadow-md">Solidarité et Entraide</h3>
                        <p class="mt-2 text-lg drop-shadow-md">Un espace pour partager et se soutenir mutuellement.</p>
                    </div>
                </div>
                <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1510519138101-570d1dca3d66?q=80&w=2910&auto=format&fit=crop'); background-size: cover; background-position: center;">
                    <div class="slide-content">
                        <h3 class="text-3xl font-bold drop-shadow-md">Événements Sociaux</h3>
                        <p class="mt-2 text-lg drop-shadow-md">Participez à des événements et rencontrez d'autres jeunes.</p>
                    </div>
                </div>
            </div>
            <div class="flex justify-between mt-6">
                <button class="button-nav" onclick="prevSlide()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="button-nav" onclick="nextSlide()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
            <div class="flex justify-center mt-10">
                <a href="#services" class="bg-blue-600 text-white px-8 py-3 rounded-full hover:bg-blue-700 transition-colors shadow-lg font-semibold">
                    Découvrez nos activités
                </a>
            </div>
        </div>
    </section>

    <section id="about" class="py-16 md:py-24">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="order-2 md:order-1">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Notre Mission</h2>
                <p class="text-gray-600 dark:text-gray-300 text-lg mb-6 leading-relaxed">
                    Depuis 2020, notre association s'engage à soutenir les jeunes dans leur développement personnel et professionnel. Nous croyons en la force de la solidarité pour bâtir une communauté forte et résiliente.
                </p>
                <p class="text-gray-600 dark:text-gray-300 text-lg leading-relaxed">
                    À travers nos programmes et nos événements, nous offrons un cadre bienveillant où chaque jeune peut s'épanouir, partager ses idées et réaliser ses ambitions.
                </p>
                <div class="mt-8">
                    <a href="#" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                        En savoir plus sur nous
                        <svg class="ml-3 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 15.707a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L9 12.586V4a1 1 0 112 0v8.586l2.293-2.293a1 1 0 111.414 1.414l-4 4z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="order-1 md:order-2">
                <img src="https://images.unsplash.com/photo-1522204523234-8729aa6e993e?q=80&w=2940&auto=format&fit=crop" alt="À propos de l'association" class="rounded-xl shadow-2xl transition-transform duration-500 hover:scale-105">
            </div>
        </div>
    </section>

    <section id="services" class="py-16 md:py-24">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-12">Nos Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-600 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.484 9.498 5 8 5c-1.506 0-2.832.484-4 1.253v13C4.168 18.484 5.494 18 7 18c1.506 0 2.832.484 4 1.253M12 6.253C13.168 5.484 14.502 5 16 5c1.506 0 2.832.484 4 1.253v13C19.832 18.484 18.506 18 17 18c-1.506 0-2.832.484-4 1.253" />
                        </svg>
                        <h3 class="font-bold text-xl">Ateliers de Formation</h3>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">
                        Des formations variées pour développer vos compétences et vos talents, animées par des experts.
                    </p>
                    <img src="https://images.unsplash.com/photo-1549227546-2713f0a7114d?q=80&w=2940&auto=format&fit=crop" alt="Ateliers de Formation" class="mt-4 rounded-lg shadow-sm w-full h-40 object-cover">
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-600 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h3 class="font-bold text-xl">Événements Sociaux</h3>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">
                        Participez à des événements pour rencontrer d'autres jeunes et créer des liens durables.
                    </p>
                    <img src="https://images.unsplash.com/photo-1510519138101-570d1dca3d66?q=80&w=2910&auto=format&fit=crop" alt="Événements Sociaux" class="mt-4 rounded-lg shadow-sm w-full h-40 object-cover">
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-600 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <h3 class="font-bold text-xl">Soutien Psychologique</h3>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">
                        Des services d'écoute et de soutien pour vous accompagner dans les moments difficiles.
                    </p>
                    <img src="https://images.unsplash.com/photo-1522204523234-8729aa6e993e?q=80&w=2940&auto=format&fit=crop" alt="Soutien Psychologique" class="mt-4 rounded-lg shadow-sm w-full h-40 object-cover">
                </div>
            </div>
        </div>
    </section>

    <section id="testimonials" class="py-16 md:py-24 bg-gray-100 dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-12">Ce qu'ils disent de nous</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow-lg transform transition-transform hover:scale-105 duration-300">
                    <div class="flex items-center mb-4">
                        <img class="w-16 h-16 rounded-full mr-4" src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=1976&auto=format&fit=crop" alt="Photo de l'utilisateur">
                        <div>
                            <p class="font-semibold text-lg">Marie Dupont</p>
                            <p class="text-gray-500 dark:text-gray-400">Membre de l'association</p>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 italic">"Grâce à l'association, j'ai pu participer à des ateliers qui m'ont permis de trouver ma passion. C'est une communauté formidable !"</p>
                </div>
                <div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow-lg transform transition-transform hover:scale-105 duration-300">
                    <div class="flex items-center mb-4">
                        <img class="w-16 h-16 rounded-full mr-4" src="https://images.unsplash.com/photo-1628157588553-5eeea00af15c?q=80&w=2940&auto=format&fit=crop" alt="Photo de l'utilisateur">
                        <div>
                            <p class="font-semibold text-lg">David Chen</p>
                            <p class="text-gray-500 dark:text-gray-400">Bénévole</p>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 italic">"L'entraide et le soutien que j'ai trouvés ici sont incroyables. Je me sens utile en contribuant à cette belle mission."</p>
                </div>
                <div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow-lg transform transition-transform hover:scale-105 duration-300">
                    <div class="flex items-center mb-4">
                        <img class="w-16 h-16 rounded-full mr-4" src="https://images.unsplash.com/photo-1607346256330-dee7af1567e0?q=80&w=2940&auto=format&fit=crop" alt="Photo de l'utilisateur">
                        <div>
                            <p class="font-semibold text-lg">Sophie Lemaire</p>
                            <p class="text-gray-500 dark:text-gray-400">Partenaire</p>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 italic">"Nous sommes fiers de collaborer avec cette association. Leur impact positif sur la jeunesse est remarquable."</p>
                </div>
            </div>
        </div>
    </section>

    <section id="news" class="py-16 md:py-24">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-12">Nouvelles de l'Association</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <img src="https://images.unsplash.com/photo-1549227546-2713f0a7114d?q=80&w=2940&auto=format&fit=crop" alt="Atelier de Création Artistique" class="rounded-lg mb-4 w-full h-48 object-cover">
                    <h3 class="font-bold text-xl mb-2">Atelier de Création Artistique</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Rejoignez-nous pour un atelier où vous pourrez exprimer votre créativité à travers l'art.
                    </p>
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold transition-colors">
                        Lire la suite
                        <span class="ml-1">→</span>
                    </a>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <img src="https://images.unsplash.com/photo-1532619082216-5231c6a782a2?q=80&w=2940&auto=format&fit=crop" alt="Journée de Nettoyage" class="rounded-lg mb-4 w-full h-48 object-cover">
                    <h3 class="font-bold text-xl mb-2">Journée de Nettoyage</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Participez à notre journée de nettoyage pour faire une différence dans notre communauté.
                    </p>
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold transition-colors">
                        Lire la suite
                        <span class="ml-1">→</span>
                    </a>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <img src="https://images.unsplash.com/photo-1519708779421-ce118a65c276?q=80&w=2940&auto=format&fit=crop" alt="Soirée de Jeux" class="rounded-lg mb-4 w-full h-48 object-cover">
                    <h3 class="font-bold text-xl mb-2">Soirée de Jeux</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Venez vous amuser lors de notre soirée de jeux et rencontrer d'autres membres de l'association.
                    </p>
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold transition-colors">
                        Lire la suite
                        <span class="ml-1">→</span>
                    </a>
                </div>
            </div>
            <div class="flex justify-center mt-12">
                <a href="#" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-blue-600 bg-white hover:bg-gray-100 dark:bg-gray-900 dark:text-white dark:hover:bg-gray-700 transition-colors">
                    Voir toutes les nouvelles
                    <svg class="ml-3 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 15.707a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L9 12.586V4a1 1 0 112 0v8.586l2.293-2.293a1 1 0 111.414 1.414l-4 4z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </section>


    <section id="cta" class="py-16 md:py-24 bg-blue-600 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Agissez pour la jeunesse</h2>
            <p class="text-xl mb-8">Votre soutien fait une réelle différence. Devenez bénévole ou faites un don dès aujourd'hui.</p>
            <div class="flex flex-col md:flex-row justify-center space-y-4 md:space-y-0 md:space-x-4">
                <a href="#" class="bg-white text-blue-600 px-8 py-3 rounded-full shadow-lg hover:bg-gray-100 transition-colors font-semibold">
                    Devenir Bénévole
                </a>
                <a href="#" class="bg-white text-blue-600 px-8 py-3 rounded-full shadow-lg hover:bg-gray-100 transition-colors font-semibold">
                    Faire un Don
                </a>
            </div>
        </div>
    </section>

    <section id="contact" class="py-16 md:py-24">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-12">Contactez-nous</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
                <form class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-200 mb-2 font-semibold" for="name">Nom</label>
                        <input class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" type="text" id="name" required>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-200 mb-2 font-semibold" for="email">Email</label>
                        <input class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" type="email" id="email" required>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-200 mb-2 font-semibold" for="message">Message</label>
                        <textarea class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" id="message" rows="5" required></textarea>
                    </div>
                    <button class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold" type="submit">Envoyer le message</button>
                </form>
                <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg flex flex-col justify-between">
                    <div>
                        <h3 class="text-2xl font-bold mb-4">Nos coordonnées</h3>
                        <div class="space-y-4 text-gray-600 dark:text-gray-300">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <p>123 Rue de l'Association, 75000 Paris</p>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <p>+33 1 23 45 67 89</p>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p>contact@associationjeunes.fr</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-2xl font-bold mb-4">Réseaux sociaux</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="text-blue-600 hover:text-blue-800 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.505 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.774-1.63 1.572V12h2.77l-.443 2.89h-2.327v6.987C18.343 21.128 22 16.991 22 12z" />
                                </svg>
                            </a>
                            <a href="#" class="text-blue-600 hover:text-blue-800 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.477 2 2 6.477 2 12c0 4.418 2.863 8.167 6.848 9.49l-.534-1.921c-2.316-1.12-3.957-3.328-3.957-5.569 0-3.313 2.687-6 6-6s6 2.687 6 6c0 2.241-1.641 4.449-3.957 5.569l-.534 1.921c3.985-1.323 6.848-5.072 6.848-9.49 0-5.523-4.477-10-10-10zm0 18.005a8.005 8.005 0 010-16.01 8.005 8.005 0 010 16.01z" />
                                </svg>
                            </a>
                            <a href="#" class="text-blue-600 hover:text-blue-800 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2zM8.99 12c0-1.66 1.34-3 3-3s3 1.34 3 3-1.34 3-3 3-3-1.34-3-3zm4.5-5a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-800 dark:bg-gray-900 text-gray-300 py-8">
        <div class="container mx-auto px-4 text-center">
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

        showSlide(currentIndex);

        let slideInterval = setInterval(nextSlide, 5000); 

        const slider = document.querySelector('.slider');
        slider.addEventListener('mouseenter', () => clearInterval(slideInterval));
        slider.addEventListener('mouseleave', () => slideInterval = setInterval(nextSlide, 5000));
        
        function toggleTheme() {
            const body = document.body;
            body.classList.toggle("dark");
            const isDark = body.classList.contains("dark");
            
            // Toggle icons for desktop
            const desktopDarkIcon = document.getElementById("theme-toggle-dark-icon");
            const desktopLightIcon = document.getElementById("theme-toggle-light-icon");
            if (desktopDarkIcon && desktopLightIcon) {
                desktopDarkIcon.classList.toggle("hidden", !isDark);
                desktopLightIcon.classList.toggle("hidden", isDark);
            }
            
            // Toggle icons for mobile
            const mobileDarkIcon = document.getElementById("theme-toggle-dark-icon-mobile");
            const mobileLightIcon = document.getElementById("theme-toggle-light-icon-mobile");
            if (mobileDarkIcon && mobileLightIcon) {
                mobileDarkIcon.classList.toggle("hidden", !isDark);
                mobileLightIcon.classList.toggle("hidden", isDark);
            }
        }

        // Attach event listeners to both buttons
        document.getElementById("theme-toggle").addEventListener("click", toggleTheme);
        document.getElementById("theme-toggle-mobile").addEventListener("click", toggleTheme);

        document.getElementById("dropdownButton").addEventListener("click", function() {
            document.getElementById("dropdownMenu").classList.toggle("hidden");
        });

        document.getElementById("hamburger-button").addEventListener("click", function() {
            document.getElementById("mobile-menu").classList.toggle("hidden");
        });

        window.onclick = function(event) {
            if (!event.target.matches('#dropdownButton') && !event.target.matches('#dropdownButton *')) {
                const dropdownMenu = document.getElementById("dropdownMenu");
                if (dropdownMenu && !dropdownMenu.classList.contains('hidden')) {
                    dropdownMenu.classList.add('hidden');
                }
            }
        };
    </script>
</body>

</html>