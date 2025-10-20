<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNO NutriMap Map</title>
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
        /* Custom styles for the arrow animation */
        .arrow-icon {
            transition: transform 0.3s ease-in-out;
        }
        .arrow-down {
            transform: rotate(180deg);
        }
        /* Custom styles for the message box */
        .message-box {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            z-index: 50;
            max-width: 400px;
            text-align: center;
        }
        .message-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen bg-gray-100 text-gray-800">

    <!-- Header Section -->
    <header class="flex justify-between items-center p-6 lg:px-10 bg-white shadow-md z-20">
        <div class="flex items-center">
            <img src="../../../img/CNO_Logo.jpg" alt="CNO NutriMap Logo" class="h-10 mr-2 rounded-lg">
            <span class="text-2xl font-bold text-[#00a0a0]">CNO</span><span class="text-2xl font-bold ml-1">NutriMap</span>
        </div>
        <nav class="flex items-center space-x-6">
            <a href="../../../index.php" class="text-gray-600 hover:text-gray-900 font-semibold px-4 py-2 rounded-md transition duration-300 ease-in-out">Home</a>
            <a href="../../pages/map_us/map.php" class="bg-[#00a0a0] text-white font-semibold px-4 py-2 rounded-md transition duration-300 ease-in-out shadow-md">Map</a>
            
            <!-- About Dropdown with rotating arrow -->
            <div class="relative">
                <button id="about-button" class="flex items-center space-x-2 text-gray-800 font-semibold px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors focus:outline-none">
                    <span>About CNO</span>
                    <!-- SVG for the arrow, which will be animated -->
                    <svg id="arrow-icon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 arrow-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdown-menu" class="absolute left-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-xl py-2 hidden transition-all duration-300 ease-out">
                    <a href="../../pages/about_us/profile.php" class="group flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#00a0a0] rounded-md">
                        Profile
                        <svg class="h-4 w-4 text-gray-500 group-hover:block invisible group-hover:visible transition-all duration-300 ease-in-out" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="../../pages/about_us/history.php" class="group flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#00a0a0] rounded-md">
                        History
                        <svg class="h-4 w-4 text-gray-500 group-hover:block invisible group-hover:visible transition-all duration-300 ease-in-out" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="../../pages/about_us/mission.php" class="group flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#00a0a0] rounded-md">
                        Mission
                        <svg class="h-4 w-4 text-gray-500 group-hover:block invisible group-hover:visible transition-all duration-300 ease-in-out" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="../../pages/about_us/vision.php" class="group flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#00a0a0] rounded-md">
                        Vision
                        <svg class="h-4 w-4 text-gray-500 group-hover:block invisible group-hover:visible transition-all duration-300 ease-in-out" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <a href="../../pages/contact_us/contact.php" class="text-gray-600 hover:text-gray-900 font-semibold px-4 py-2 rounded-md transition duration-300 ease-in-out">Contact</a>
            <a href="../../Frontend/login.php" class="bg-white text-[#00a0a0] border border-[#00a0a0] font-semibold px-4 py-2 rounded-md transition duration-300 ease-in-out hover:bg-gray-50">Login</a>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col items-center px-4 py-10 lg:px-20 text-left">
        <section class="w-full max-w-5xl mb-5">
            <h2 class="text-xl text-gray-600 font-normal mb-1">DATA</h2>
            <h1 class="text-4xl font-bold text-gray-800">Health and Nutrition: Share of Children who are stunted</h1>
        </section>

        <section class="w-full max-w-5xl bg-white rounded-lg shadow-lg p-5 flex flex-col lg:flex-row gap-5">
            <!-- Map and Color Bar Section -->
            <div class="flex-grow flex flex-col">
                <div class="text-sm lg:text-base font-bold text-gray-600 mb-2">
                    El Salvador Health and Nutrition Map: Share of Children who are stunted, 2025
                </div>
                <div class="flex-grow bg-gray-50 border border-gray-300 rounded-lg flex items-center justify-center overflow-hidden relative">
                    <img src="https://placehold.co/500x300/e0e0e0/ffffff?text=Map+of+El+Salvador" alt="Map of El Salvador" class="w-full h-auto block rounded-lg">
                </div>
                <div class="mt-5 w-full">
                    <h4 class="text-sm font-semibold text-gray-600 text-center mb-1">Prevalence Rate</h4>
                    <div class="w-full h-5 rounded-md flex overflow-hidden">
                        <button data-percentage="0-20" class="bg-[#008CBA] w-[20%] h-full hover:bg-opacity-80 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#008CBA] focus:ring-offset-2"></button>
                        <button data-percentage="21-40" class="bg-[#4CAF50] w-[20%] h-full hover:bg-opacity-80 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#4CAF50] focus:ring-offset-2"></button>
                        <button data-percentage="41-60" class="bg-[#FFC107] w-[20%] h-full hover:bg-opacity-80 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#FFC107] focus:ring-offset-2"></button>
                        <button data-percentage="61-80" class="bg-[#FF9800] w-[20%] h-full hover:bg-opacity-80 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#FF9800] focus:ring-offset-2"></button>
                        <button data-percentage="81-100" class="bg-[#F44336] w-[20%] h-full hover:bg-opacity-80 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#F44336] focus:ring-offset-2"></button>
                    </div>
                    <div id="prevalence-labels" class="flex justify-between text-xs text-gray-500 mt-1">
                        <button data-percentage="0" class="px-1 rounded-md hover:bg-gray-200 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">0%</button>
                        <button data-percentage="10" class="px-1 rounded-md hover:bg-gray-200 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">10%</button>
                        <button data-percentage="20" class="px-1 rounded-md hover:bg-gray-200 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">20%</button>
                        <button data-percentage="30" class="px-1 rounded-md hover:bg-gray-200 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">30%</button>
                        <button data-percentage="40" class="px-1 rounded-md hover:bg-gray-200 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">40%</button>
                        <button data-percentage="50" class="px-1 rounded-md hover:bg-gray-200 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">50%</button>
                        <button data-percentage="60" class="px-1 rounded-md hover:bg-gray-200 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">60%</button>
                        <button data-percentage="70" class="px-1 rounded-md hover:bg-gray-200 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">70%</button>
                        <button data-percentage="80" class="px-1 rounded-md hover:bg-gray-200 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">80%</button>
                        <button data-percentage="90" class="px-1 rounded-md hover:bg-gray-200 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">90%</button>
                        <button data-percentage="100" class="px-1 rounded-md hover:bg-gray-200 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">100%</button>
                    </div>
                </div>
            </div>

            <!-- Controls and Legend Section -->
            <aside class="w-full lg:w-64 flex flex-col gap-5">
                <div class="flex flex-col gap-1">
                    <label for="year" class="text-sm font-semibold text-gray-600">SELECT YEAR</label>
                    <select id="year" class="w-full p-2 border border-gray-300 rounded-md text-sm text-gray-800">
                        <option value="all">ALL</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                    </select>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="barangay" class="text-sm font-semibold text-gray-600">SELECT BARANGAY</label>
                    <select id="barangay" class="w-full p-2 border border-gray-300 rounded-md text-sm text-gray-800">
                        <option value="all">ALL</option>
                        <option value="barangay1">Barangay 1</option>
                        <option value="barangay2">Barangay 2</option>
                    </select>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="age-bracket" class="text-sm font-semibold text-gray-600">AGE BRACKET</label>
                    <select id="age-bracket" class="w-full p-2 border border-gray-300 rounded-md text-sm text-gray-800">
                        <option value="1-10">1-10</option>
                        <option value="11-20">11-20</option>
                    </select>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 text-center mb-2">Legend</h3>
                    <div id="legend-list" class="flex flex-col gap-2">
                        <button data-percentage="0-20" class="flex items-center gap-2 p-2 rounded-md hover:bg-gray-100 transition-all duration-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#008CBA] focus:ring-offset-2">
                            <div class="w-5 h-5 rounded-sm border border-gray-400 bg-[#008CBA]"></div>
                            <span>Underweight</span>
                        </button>
                        <button data-percentage="21-40" class="flex items-center gap-2 p-2 rounded-md hover:bg-gray-100 transition-all duration-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#4CAF50] focus:ring-offset-2">
                            <div class="w-5 h-5 rounded-sm border border-gray-400 bg-[#4CAF50]"></div>
                            <span>Normal</span>
                        </button>
                        <button data-percentage="41-60" class="flex items-center gap-2 p-2 rounded-md hover:bg-gray-100 transition-all duration-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#FFC107] focus:ring-offset-2">
                            <div class="w-5 h-5 rounded-sm border border-gray-400 bg-[#FFC107]"></div>
                            <span>Overweight</span>
                        </button>
                        <button data-percentage="61-80" class="flex items-center gap-2 p-2 rounded-md hover:bg-gray-100 transition-all duration-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF9800] focus:ring-offset-2">
                            <div class="w-5 h-5 rounded-sm border border-gray-400 bg-[#FF9800]"></div>
                            <span>Obese</span>
                        </button>
                        <button data-percentage="81-100" class="flex items-center gap-2 p-2 rounded-md hover:bg-gray-100 transition-all duration-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#F44336] focus:ring-offset-2">
                            <div class="w-5 h-5 rounded-sm border border-gray-400 bg-[#F44336]"></div>
                            <span>Severely Obese</span>
                        </button>
                    </div>
                </div>
            </aside>
        </section>

        <p class="data-source text-sm text-gray-600 mt-5 w-full max-w-5xl">
            Data source: El Salvador City Nutrition Office
        </p>

        <section class="indicator-info w-full max-w-5xl mt-10">
            <h2 class="text-2xl font-bold text-gray-800 border-b-2 border-gray-300 pb-2 mb-4">What you should know about this indicator</h2>
            <p class="text-gray-700 text-justify">
                The prevalence of stunting is a key indicator used to assess the nutritional status of a community. Stunting is the impaired growth and development that children experience from poor nutrition, repeated infection, and inadequate psychosocial stimulation. Children who are stunted may have a reduced ability to learn and are at higher risk of non-communicable diseases later in life. This map provides a visual representation of stunting rates across different barangays, helping to identify areas that require immediate attention and resources to improve child nutrition.
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
                        <img src="../../../img/CNO_Logo.jpg" alt="CNO NutriMap Logo" class="h-10 mr-2 rounded-lg">
                        <span class="text-2xl font-bold text-[#00a0a0]">CNO</span><span class="text-2xl font-bold ml-1 text-white">NutriMap</span>
                    </div>
                    <p class="text-sm">A tool to visualize health and nutrition data for children in El Salvador City.</p>
                </div>
                <!-- Links Column 1 -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">About Us</h3>
                    <ul class="space-y-2">
                        <li><a href="javascript:void(0)" class="hover:text-[#00a0a0] transition-colors duration-200">Our Mission</a></li>
                        <li><a href="javascript:void(0)" class="hover:text-[#00a0a0] transition-colors duration-200">Our Vision</a></li>
                        <li><a href="javascript:void(0)" class="hover:text-[#00a0a0] transition-colors duration-200">History</a></li>
                    </ul>
                </div>
                <!-- Links Column 2 -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="javascript:void(0)" class="hover:text-[#00a0a0] transition-colors duration-200">Map</a></li>
                        <li><a href="javascript:void(0)" class="hover:text-[#00a0a0] transition-colors duration-200">Data</a></li>
                        <li><a href="javascript:void(0)" class="hover:text-[#00a0a0] transition-colors duration-200">Contact Us</a></li>
                    </ul>
                </div>
                <!-- Legal & Support Column -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Legal & Support</h3>
                    <ul class="space-y-2">
                        <li><a href="javascript:void(0)" class="hover:text-[#00a0a0] transition-colors duration-200">Terms</a></li>
                        <li><a href="javascript:void(0)" class="hover:text-[#00a0a0] transition-colors duration-200">Privacy Policy</a></li>
                        <li><a href="javascript:void(0)" class="hover:text-[#00a0a0] transition-colors duration-200">Cookies</a></li>
                        <li><a href="javascript:void(0)" class="hover:text-[#00a0a0] transition-colors duration-200">Help</a></li>
                        <li><a href="javascript:void(0)" class="hover:text-[#00a0a0] transition-colors duration-200">FAQs</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-700 pt-8 text-center">
                <p class="text-gray-400">Copyright&copy; 2025 CNO NutriMap All Rights Reserved. Developed By NBSC ICS 4th Year Student.</p>
            </div>
        </div>
    </footer>

    <!-- Custom Message Box -->
    <div id="message-overlay" class="message-overlay hidden"></div>
    <div id="message-box" class="message-box hidden">
        <div id="message-content" class="text-lg font-semibold text-gray-900 mb-4"></div>
        <button id="close-message" class="bg-[#00a0a0] text-white px-4 py-2 rounded-full hover:bg-[#008c8c] transition-colors">Close</button>
    </div>

    <!-- JavaScript for interactivity -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const prevalenceBar = document.querySelector('#prevalence-labels').previousElementSibling;
            const legendList = document.getElementById('legend-list');
            const prevalenceLabels = document.getElementById('prevalence-labels');
            const messageBox = document.getElementById('message-box');
            const messageContent = document.getElementById('message-content');
            const closeMessageBtn = document.getElementById('close-message');
            const messageOverlay = document.getElementById('message-overlay');

            const aboutButton = document.getElementById('about-button');
            const dropdownMenu = document.getElementById('dropdown-menu');
            const arrowIcon = document.getElementById('arrow-icon');
            
            // Toggle dropdown and rotate arrow on button click
            aboutButton.addEventListener('click', (event) => {
                event.preventDefault();
                event.stopPropagation();
                dropdownMenu.classList.toggle('hidden');
                arrowIcon.classList.toggle('arrow-down');
            });

            // Close the dropdown if the user clicks anywhere else on the page
            document.addEventListener('click', (event) => {
                if (!aboutButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.add('hidden');
                    arrowIcon.classList.remove('arrow-down');
                }
            });

            const showMessage = (text) => {
                messageContent.innerText = text;
                messageBox.classList.remove('hidden');
                messageOverlay.classList.remove('hidden');
            };

            const hideMessage = () => {
                messageBox.classList.add('hidden');
                messageOverlay.classList.add('hidden');
            };

            // Event listener for Prevalence Bar
            prevalenceBar.addEventListener('click', (event) => {
                const target = event.target.closest('button');
                if (target && target.dataset.percentage) {
                    const percentage = target.dataset.percentage;
                    showMessage(`Prevalence rate is between ${percentage}%`);
                }
            });

            // Event listener for individual percentage buttons
            prevalenceLabels.addEventListener('click', (event) => {
                const target = event.target.closest('button');
                if (target && target.dataset.percentage) {
                    const percentage = target.dataset.percentage;
                    showMessage(`Prevalence rate is approximately ${percentage}%`);
                }
            });

            // Event listener for Legend items
            legendList.addEventListener('click', (event) => {
                const target = event.target.closest('button');
                if (target && target.dataset.percentage) {
                    const status = target.querySelector('span').innerText;
                    const percentage = target.dataset.percentage;
                    showMessage(`${status} range: ${percentage}%`);
                }
            });

            // Event listener for closing the message box
            closeMessageBtn.addEventListener('click', hideMessage);
            messageOverlay.addEventListener('click', hideMessage);
        });
    </script>
</body>
</html>
