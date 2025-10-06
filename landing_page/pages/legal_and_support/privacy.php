<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - CNO NutriMap</title>
    <link rel="icon" type="image/png" href="../../css/image/CNO_Logo.png">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
        .arrow-icon {
            transition: transform 0.3s ease-in-out;
        }
        .arrow-down {
            transform: rotate(180deg);
        }
    </style>
</head>
<body class="flex flex-col min-h-screen bg-gray-100 text-gray-800">

    <!-- Header Section -->
    <header class="flex justify-between items-center p-6 lg:px-10 bg-white shadow-md z-20">
        <div class="flex items-center">
            <img src="../../css/image/CNO_Logo.png" alt="CNO NutriMap Logo" class="h-10 mr-2 rounded-lg">
            <span class="text-2xl font-bold text-[#00a0a0]">CNO</span><span class="text-2xl font-bold ml-1">NutriMap</span>
        </div>
        <nav class="flex items-center space-x-6">
            <a href="../../../index.php" class="text-gray-600 hover:text-gray-900 font-semibold px-4 py-2 rounded-md transition duration-300 ease-in-out">Home</a>
            <a href="../../map.php" class="text-gray-600 hover:text-gray-900 font-semibold px-4 py-2 rounded-md transition duration-300 ease-in-out">Map</a>
            
            <!-- About Dropdown with rotating arrow -->
            <div class="relative">
                <button id="about-button" class="flex items-center space-x-2 text-gray-800 font-semibold px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors focus:outline-none">
                    <span>About CNO</span>
                    <svg id="about-arrow-icon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 arrow-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="about-dropdown-menu" class="absolute left-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-xl py-2 hidden transition-all duration-300 ease-out">
                    <a href="../../pages/about_us/profile.php" class="group flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#00a0a0] rounded-md">
                        <span>Profile</span>
                        <svg class="h-4 w-4 text-gray-500 group-hover:block invisible group-hover:visible transition-all duration-300 ease-in-out" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="../../pages/about_us/history.php" class="group flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#00a0a0] rounded-md">
                        <span>History</span>
                        <svg class="h-4 w-4 text-gray-500 group-hover:block invisible group-hover:visible transition-all duration-300 ease-in-out" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="../../pages/about_us/mission.php" class="group flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#00a0a0] rounded-md">
                        <span>Mission</span>
                        <svg class="h-4 w-4 text-gray-500 group-hover:block invisible group-hover:visible transition-all duration-300 ease-in-out" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="../../pages/about_us/vision.php" class="group flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#00a0a0] rounded-md">
                        <span>Vision</span>
                        <svg class="h-4 w-4 text-gray-500 group-hover:block invisible group-hover:visible transition-all duration-300 ease-in-out" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Contact Dropdown with rotating arrow -->
            <div class="relative">
                <button id="contact-button" class="flex items-center space-x-2 bg-[#00a0a0] text-white font-semibold px-4 py-2 rounded-md transition duration-300 ease-in-out shadow-md focus:outline-none">
                    <span>Contact</span>
                    <svg id="contact-arrow-icon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white arrow-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="contact-dropdown-menu" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-xl py-2 hidden transition-all duration-300 ease-out">
                    <a href="../../pages/contact_us/get_in_touch.php" class="group flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#00a0a0] rounded-md">
                        <span>Get In Touch</span>
                        <svg class="h-4 w-4 text-gray-500 group-hover:block invisible group-hover:visible transition-all duration-300 ease-in-out" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="../../pages/contact_us/downloadable_form.php" class="group flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#00a0a0] rounded-md">
                        <span>Downloadable Form</span>
                        <svg class="h-4 w-4 text-gray-500 group-hover:block invisible group-hover:visible transition-all duration-300 ease-in-out" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="../../pages/contact_us/feedback.php" class="group flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#00a0a0] rounded-md">
                        <span>Feedback</span>
                        <svg class="h-4 w-4 text-gray-500 group-hover:block invisible group-hover:visible transition-all duration-300 ease-in-out" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <a href="../../Frontend/login.php" class="bg-white text-[#00a0a0] border border-[#00a0a0] font-semibold px-4 py-2 rounded-md transition duration-300 ease-in-out hover:bg-gray-50">Login</a>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col items-center px-4 py-10 lg:px-20 text-center">
        <section class="w-full max-w-4xl bg-white rounded-lg shadow-lg p-8 text-left">
            <h1 class="text-3xl font-bold text-gray-800 mb-4 text-center">Privacy Policy</h1>
            <p class="text-gray-600 mb-6 text-center">
                Mahalaga sa amin ang inyong privacy. Ipinapaliwanag ng policy na ito kung paano namin kinokolekta, ginagamit, at pinoprotektahan ang inyong personal na impormasyon.
            </p>

            <h2 class="text-2xl font-semibold text-gray-700 mb-2">1. Impormasyong Kinokolekta Namin</h2>
            <p class="text-gray-600 mb-4">
                Kapag gumagamit kayo ng CNO NutriMap, maaari kaming mangolekta ng impormasyon na ibinigay ninyo nang kusa, tulad ng pangalan, email address, at iba pang contact details na isinumite sa pamamagitan ng forms.
            </p>
            
            <h2 class="text-2xl font-semibold text-gray-700 mb-2">2. Paano Namin Ginagamit ang Impormasyon</h2>
            <p class="text-gray-600 mb-4">
                Ginagamit namin ang impormasyon upang mapabuti ang serbisyo, tumugon sa inyong mga katanungan, at magbigay ng updates. Hindi namin ipagbebenta, ibabahagi, o ilalabas ang inyong impormasyon sa mga third parties maliban na lang kung kinakailangan ng batas.
            </p>
            
            <h2 class="text-2xl font-semibold text-gray-700 mb-2">3. Seguridad ng Datos</h2>
            <p class="text-gray-600 mb-4">
                Ginagamit namin ang iba't ibang security measures upang mapanatiling ligtas ang inyong personal na datos. Gayunpaman, walang method ng electronic storage na 100% ligtas.
            </p>

            <h2 class="text-2xl font-semibold text-gray-700 mb-2">4. Pagbabago sa Policy</h2>
            <p class="text-gray-600">
                Maaari naming i-update ang privacy policy na ito anumang oras. Inaabisuhan namin kayo na regular na suriin ang page na ito para sa mga pagbabago.
            </p>
        </section>
    </main>
    
    <!-- Footer Section -->
    <footer class="bg-gray-800 text-gray-300 py-4 mt-auto">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
                <!-- Logo and Description -->
                <div class="flex flex-col items-start md:col-span-2">
                    <div class="flex items-center mb-4">
                        <img src="../../css/image/CNO_Logo.png" alt="CNO NutriMap Logo" class="h-10 mr-2 rounded-lg">
                        <span class="text-2xl font-bold text-[#00a0a0]">CNO</span><span class="text-2xl font-bold ml-1 text-white">NutriMap</span>
                    </div>
                    <p class="text-sm">A tool to visualize health and nutrition data for children in El Salvador City.</p>
                </div>
                <!-- Links Column 1 -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">About Us</h3>
                    <ul class="space-y-2">
                        <li><a href="../../pages/about_us/mission.php" class="hover:text-[#00a0a0] transition-colors duration-200">Our Mission</a></li>
                        <li><a href="../../pages/about_us/vision.php" class="hover:text-[#00a0a0] transition-colors duration-200">Our Vision</a></li>
                        <li><a href="../../pages/about_us/history.php" class="hover:text-[#00a0a0] transition-colors duration-200">History</a></li>
                    </ul>
                </div>
                <!-- Links Column 2 -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="../../pages/map_us/map.php" class="hover:text-[#00a0a0] transition-colors duration-200">Map</a></li>
                        <li><a href="../../pages/contact_us/get_in_touch.php" class="hover:text-[#00a0a0] transition-colors duration-200">Contact Us</a></li>
                        <li><a href="../../pages/contact_us/downloadable_form.php" class="hover:text-[#00a0a0] transition-colors duration-200">Downloadable Forms</a></li>
                    </ul>
                </div>
                <!-- Legal & Support Column -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Legal & Support</h3>
                    <ul class="space-y-2">
                        <li><a href="../../pages/legal_and_support/terms.php" class="hover:text-[#00a0a0] transition-colors duration-200">Terms of Use</a></li>
                        <li><a href="../../pages/legal_and_support/privacy.php" class="hover:text-[#00a0a0] transition-colors duration-200">Privacy Policy</a></li>
                        <li><a href="../../pages/legal_and_support/cookies.php" class="hover:text-[#00a0a0] transition-colors duration-200">Cookies</a></li>
                        <li><a href="../../pages/help_and_support/help.php" class="hover:text-[#00a0a0] transition-colors duration-200">Help</a></li>
                        <li><a href="../../pages/help_and_support/faqs.php" class="hover:text-[#00a0a0] transition-colors duration-200">FAQs</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-700 pt-8 text-center">
                <p class="text-gray-400">Copyright&copy; 2025 CNO NutriMap All Rights Reserved. Developed By NBSC ICS 4th Year Student.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript for interactivity -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const aboutButton = document.getElementById('about-button');
            const aboutDropdownMenu = document.getElementById('about-dropdown-menu');
            const aboutArrowIcon = document.getElementById('about-arrow-icon');
            
            const contactButton = document.getElementById('contact-button');
            const contactDropdownMenu = document.getElementById('contact-dropdown-menu');
            const contactArrowIcon = document.getElementById('contact-arrow-icon');

            // Toggle dropdown for About
            aboutButton.addEventListener('click', (event) => {
                event.preventDefault();
                event.stopPropagation();
                aboutDropdownMenu.classList.toggle('hidden');
                aboutArrowIcon.classList.toggle('arrow-down');
                // Hide other dropdown
                contactDropdownMenu.classList.add('hidden');
                contactArrowIcon.classList.remove('arrow-down');
            });
            
            // Toggle dropdown for Contact
            contactButton.addEventListener('click', (event) => {
                event.preventDefault();
                event.stopPropagation();
                contactDropdownMenu.classList.toggle('hidden');
                contactArrowIcon.classList.toggle('arrow-down');
                // Hide other dropdown
                aboutDropdownMenu.classList.add('hidden');
                aboutArrowIcon.classList.remove('arrow-down');
            });

            // Close all dropdowns if the user clicks anywhere else
            document.addEventListener('click', (event) => {
                if (!aboutButton.contains(event.target) && !aboutDropdownMenu.contains(event.target)) {
                    aboutDropdownMenu.classList.add('hidden');
                    aboutArrowIcon.classList.remove('arrow-down');
                }
                if (!contactButton.contains(event.target) && !contactDropdownMenu.contains(event.target)) {
                    contactDropdownMenu.classList.add('hidden');
                    contactArrowIcon.classList.remove('arrow-down');
                }
            });
        });
    </script>
</body>
</html>
