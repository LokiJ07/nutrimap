<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNO NutriMap History</title>
    <!-- Use Tailwind CSS for modern styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../../css/image/CNO_Logo.png">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        /* New custom styles for the nav bar from index.php */
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
            background-color: #f0f2f5;
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
            top: 100%; /* Position below the dropdown link */
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
        /* Active state for dropdown links */
        .dropdown-link.active,
        .dropdown-content a.active {
            background-color: #e0f0f0;
            color: #008c8c;
            font-weight: 700;
        }
        /* Custom styles for the history timeline */
        .timeline {
            position: relative;
            padding: 2rem 0;
            width: 90%;
            max-width: 800px;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 0;
            width: 4px;
            height: 100%;
            background: #cbd5e1;
            transform: translateX(-50%);
        }
        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
            padding: 1rem 2rem;
            background-color: #fff;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            text-align: left;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            width: 1rem;
            height: 1rem;
            background-color: #00a0a0;
            border-radius: 50%;
            border: 4px solid #fff;
            top: 1.5rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
        }
        .timeline-item-left {
            left: -4%;
            width: calc(50% - 2rem);
        }
        .timeline-item-right {
            left: 54%;
            width: calc(50% - 2rem);
        }
        .timeline-item-left::after {
            content: '';
            position: absolute;
            top: 1.5rem;
            right: -0.5rem;
            border-top: 10px solid transparent;
            border-bottom: 10px solid transparent;
            border-left: 10px solid #fff;
        }
        .timeline-item-right::after {
            content: '';
            position: absolute;
            top: 1.5rem;
            left: -0.5rem;
            border-top: 10px solid transparent;
            border-bottom: 10px solid transparent;
            border-right: 10px solid #fff;
        }
        .timeline-item h3 {
            font-weight: 700;
            font-size: 1.25rem;
            color: #00a0a0;
            margin-bottom: 0.5rem;
        }
        /* Mobile adjustments */
        @media (max-width: 768px) {
            .timeline::before {
                left: 20px;
                transform: none;
            }
            .timeline-item {
                left: 0;
                width: 100%;
                padding: 1rem;
                margin-left: 40px;
            }
            .timeline-item::before {
                left: 20px;
                transform: translateX(-50%);
            }
            .timeline-item::after {
                display: none;
            }
            .timeline-item-left {
                left: 0;
                width: 100%;
            }
            .timeline-item-right {
                left: 0;
                width: 100%;
            }
        }
        /* --- Footer and Related Styling --- */
        .footer-links {
            width: 100%;
            padding: 10px 0;
            background-color: #ffffff;
            text-align: center;
            display: flex;
            justify-content: center;
            gap: 30px;
            font-weight: bold;
        }
        .footer-links a {
            color: #000;
            text-decoration: none;
            transition: color 0.3s;
        }
        .footer-links a:hover {
            color: #00a0a0;
        }
        footer {
            width: 100%;
            padding: 10px 0;
            margin-top: auto;
            background-color: #00a0a0;
            color: #ffffff;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }
        .footer-copyright {
            line-height: 1.5;
        }
        .footer-copyright span {
            display: block;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <!-- Header -->
    <header class="header">
        <div class="logo">
              <img src="../../../img/CNO_Logo.png" alt="CNO NutriMap Logo"> 
            <span class="cno-color">CNO</span><span class="logo-space"></span><span>NutriMap</span>
        </div>
        <nav class="nav">
            <a href="../../../index.php" class="nav-link">Home</a>
            <a href="../../map.php" class="nav-link">Map</a>
            <div class="dropdown">
                <a href="about.php" class="nav-link dropdown-link active">About CNO <svg class="dropdown-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></a>
                <div class="dropdown-content">
                    <a href="profile.php">Profile <i class="fas fa-caret-right"></i></a>
                    <a href="history.php">History <i class="fas fa-caret-right"></i></a>
                    <a href="vision.php">Vision <i class="fas fa-caret-right"></i></a>
                    <a href="mission.php">Mission <i class="fas fa-caret-right"></i></a>
                </div>
            </div>
            <a href="../contact_us/contact.php" class="nav-link">Contact Us</a>
            <a href="../../../login.php" class="nav-link login-btn">Login</a>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="main-content flex-grow flex flex-col items-center p-5 lg:p-10 text-justify">
        <h1 class="text-3xl lg:text-4xl font-bold mb-8 text-gray-800 text-center">Our History</h1>
        <div class="timeline">
            <!-- Timeline Item 1 -->
            <div class="timeline-item timeline-item-left">
                <h3>The Humble Beginnings (2015-2020)</h3>
                <p class="text-gray-600 leading-relaxed text-justify">
                    The City Nutrition Office (CNO) began its journey with a small, dedicated team of passionate individuals. Their primary goal was to address malnutrition and promote healthier lifestyles within the community of El Salvador. Through grassroots efforts and a commitment to serving the public, they laid the foundation for what would become a cornerstone of public health.
                </p>
            </div>
            <!-- Timeline Item 2 -->
            <div class="timeline-item timeline-item-right">
                <h3>Growth and Expansion (2020-2024)</h3>
                <p class="text-gray-600 leading-relaxed text-justify">
                    During this period, the CNO expanded its reach by implementing numerous new health programs and conducting extensive community-based research. We collaborated with various local and international partners, which significantly bolstered our capacity to combat malnutrition. Our efforts began to show measurable improvements in the community's overall nutritional status.
                </p>
            </div>
            <!-- Timeline Item 3 -->
            <div class="timeline-item timeline-item-left">
                <h3>The NutriMap Revolution (2025)</h3>
                <p class="text-gray-600 leading-relaxed text-justify">
                    A pivotal moment in our history came with the establishment of the NutriMap program. This innovative tool revolutionized how we collect and analyze nutritional data. By providing real-time insights, NutriMap allowed us to target our interventions more effectively and monitor the long-term impact of our work with unprecedented precision.
                </p>
            </div>
            <!-- Timeline Item 4 -->
            <div class="timeline-item timeline-item-right">
                <h3>Looking to the Future (2025 and Beyond)</h3>
                <p class="text-gray-600 leading-relaxed text-justify">
                    Our commitment to continuous improvement and community engagement remains at the heart of everything we do. We are immensely proud of our past achievements and are excited for the future as we continue to work toward a healthier and more nourished El Salvador. The NutriMap program is just the beginning of our journey to empower communities with better nutritional health.
                </p>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <div class="bg-gray-100 text-center p-4">
        <div class="flex justify-center space-x-6 text-sm font-semibold mb-2">
            <a href="privacy_act/terms.php" class="hover:underline text-gray-600">Terms</a>
            <a href="privacy_act/privacy.php" class="hover:underline text-gray-600">Privacy Policy</a>
            <a href="privacy_act/cookies.php" class="hover:underline text-gray-600">Cookies</a>
            <a href="privacy_act/help.php" class="hover:underline text-gray-600">Help</a>
            <a href="privacy_act/faqs.php" class="hover:underline text-gray-600">FAQs</a>
        </div>
        <p class="text-gray-500 text-xs">
            <span>Copyright © 2025 CNO NutriMap Website, All Rights Reserved.</span>
            <br>
            <span>Developed By NBSC ICS 4th Year Student</span>
        </p>
    </div>

</body>
</html>
