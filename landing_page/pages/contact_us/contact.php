<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNO NutriMap Contact Us</title>
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

          /* Header */
      .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 40px;
    background-color: #fff;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.logo {
    display: flex;
    align-items: center;
    font-weight: bold;
    font-size: 24px;
    color: #333;
}

.logo img {
    height: 40px;
    margin-right: 10px;
}

.logo .cno-color {
    color: #00a0a0;
}

.logo-space {
    margin-right: 8px;
}

.nav {
    display: flex;
    gap: 30px;
    align-items: center;
}

.nav-link {
    text-decoration: none;
    color: #666;
    font-size: 16px;
    font-weight: 600;
    padding: 8px 20px;
    border-radius: 5px;
    transition: background-color 0.3s, color 0.3s;
}

.nav-link:hover {
    color: #000;
}

.home-btn {
    background-color: #fff;
    color: #00a0a0 !important;
}

.login-btn {
    background-color: #00a0a0;
    color: #fff !important;
    border: 1px solid #00a0a0;
    padding: 10px 25px;
}

.login-btn:hover {
    background-color: #007f7f;
}

/* --- Dropdown Styling --- */
.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-link {
    display: flex;
    align-items: center;
    gap: 5px;
}

.dropdown-arrow {
    transition: transform 0.3s ease;
    width: 16px;
    height: 16px;
    fill: currentColor;
}

.dropdown:hover .dropdown-arrow {
    transform: rotate(180deg);
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    border-radius: 5px;
    overflow: hidden;
    left: 0;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    font-weight: normal;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.dropdown-content a:hover {
    background-color: #f1f1f1;
}

.dropdown:hover .dropdown-content {
    display: block;
}
    </style>
</head>
<body class="flex flex-col min-h-screen bg-gray-100 text-gray-800">

    <!-- Header Section -->
           <header class="header">
        <div class="logo">
            <span class="cno-color">CNO</span><span class="logo-space"></span><span>NutriMap</span>
        </div>
        <nav class="nav">
            <a href="../../../index.php" class="nav-link home-btn">Home</a>
            <a href="../../map.php" class="nav-link">Map</a>
            <div class="dropdown">
                <a href="../about_us/about.php" class="nav-link dropdown-link">About CNO <svg class="dropdown-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></a>
                <div class="dropdown-content">
                    <a href="../about_us/profile.php">Profile <i class="fas fa-caret-right"></i></a>
                    <a href="../about_us/history.php">History <i class="fas fa-caret-right"></i></a>
                    <a href="../about_us/vision.php">Vision <i class="fas fa-caret-right"></i></a>
                    <a href="../about_us/mission.php">Mission <i class="fas fa-caret-right"></i></a>
                </div>
            </div>
            <a href="contact.php" class="nav-link">Contact Us</a>
            <a href="../login.php" class="nav-link login-btn">Login</a>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col items-center px-4 py-10 lg:px-20 text-center">
        <section class="w-full max-w-5xl mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Contact Us</h1>
            <p class="text-xl text-gray-600">We're here to help and answer any questions you might have.</p>
        </section>

        <section class="w-full max-w-5xl bg-white rounded-lg shadow-lg p-8 flex flex-col lg:flex-row gap-8">
            <!-- Left Column: Location & Contact Info -->
            <div class="flex-1 flex flex-col items-center lg:items-start text-center lg:text-left">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Our Office</h2>
                
                <div class="w-full aspect-w-16 aspect-h-9 overflow-hidden rounded-lg shadow-md mb-6">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3945.719717156947!2d124.7709545!3d8.5991845!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32ff881d331cf113%3A0x6b8408f972b9a767!2sCity%20Nutrition%20Office!5e0!3m2!1sen!2sph!4v1716383610471!5m2!1sen!2sph" 
                        width="100%" 
                        height="400" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        class="w-full h-full">
                    </iframe>
                </div>

                <div class="w-full max-w-sm lg:max-w-none space-y-4">
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-map-marker-alt text-xl text-[#00a0a0]"></i>
                        <p class="text-gray-700">City Nutrition Office, LGU Building, El Salvador City, Misamis Oriental, Philippines</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-envelope text-xl text-[#00a0a0]"></i>
                        <a href="mailto:cnonutrimap@elsalvadorcity.gov.ph" class="text-gray-700 hover:text-[#00a0a0] transition-colors duration-200">cnonutrimap@elsalvadorcity.gov.ph</a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-phone-alt text-xl text-[#00a0a0]"></i>
                        <a href="tel:+639123456789" class="text-gray-700 hover:text-[#00a0a0] transition-colors duration-200">+63 912 345 6789</a>
                    </div>
                </div>
            </div>

            <!-- Right Column: Contact Form -->
            <div class="flex-1 w-full lg:w-auto mt-8 lg:mt-0">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Send Us a Message</h2>
                <form action="#" method="POST" class="w-full">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Full Name</label>
                        <input type="text" id="name" name="name" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00a0a0] transition-colors">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                        <input type="email" id="email" name="email" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00a0a0] transition-colors">
                    </div>
                    <div class="mb-4">
                        <label for="message" class="block text-sm font-semibold text-gray-700 mb-1">Your Message</label>
                        <textarea id="message" name="message" rows="5" required class="w-full p-3 border border-gray-300 rounded-lg resize-y focus:outline-none focus:ring-2 focus:ring-[#00a0a0] transition-colors"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-[#00a0a0] text-white font-semibold py-3 rounded-lg shadow-md hover:bg-[#008c8c] transition-colors duration-200">
                        Send Message
                    </button>
                </form>
            </div>
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
