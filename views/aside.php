<aside class="w-64 bg-white dark:bg-gray-800 hidden md:block shadow-md">
    <div class="p-6">
        <h1 class="text-xl font-bold text-primary">JS_Butembo</h1>
    </div>
    <nav class="px-4">
        <ul class="space-y-2">
            <li>
                <a href="membre.php" class="flex items-center p-2 text-gray-700 dark:text-white hover:bg-blue-100 dark:hover:bg-gray-700 rounded">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Membres
                </a>
            </li>
            <li>
                <a href="typeCotisation.php" class="flex items-center p-2 text-gray-700 dark:text-white hover:bg-blue-100 dark:hover:bg-gray-700 rounded">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 7h18M3 12h18M3 17h18" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Catégorie Cotisation
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 text-gray-700 dark:text-white hover:bg-blue-100 dark:hover:bg-gray-700 rounded">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Cotisations
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 text-gray-700 dark:text-white hover:bg-blue-100 dark:hover:bg-gray-700 rounded">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Paiements
                </a>
            </li>
            <li>
                <div class="group">
                    <button onclick="document.getElementById('rapportMenu').classList.toggle('hidden')" class="w-full flex items-center justify-between p-2 text-gray-700 dark:text-white hover:bg-blue-100 dark:hover:bg-gray-700 rounded focus:outline-none">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M3 3h18v18H3V3z" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Rapport
                        </span>
                        <svg class="w-4 h-4 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <ul id="rapportMenu" class="ml-6 mt-2 space-y-1 hidden">
                        <li><a href="#" class="block p-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 rounded">Rapport global</a></li>
                        <li><a href="#" class="block p-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 rounded">Rapport par membre</a></li>
                        <li><a href="#" class="block p-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 rounded">Rapport par période</a></li>
                    </ul>
                </div>
            </li>
        </ul>

    </nav>
</aside>