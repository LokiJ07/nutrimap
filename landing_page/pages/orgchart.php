<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNO NutriMap - Organizational Chart</title>
    <link rel="icon" type="image/jpg" href="img/CNO_Logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>

        /* General Body and Font Styles */

        body {

            font-family: 'Arial', sans-serif; /* A sans-serif font like Arial for readability */

            margin: 0;

            padding: 0;

            background-color: #f0f2f5; /* Light gray background */

            color: #333;

            display: flex;

            flex-direction: column;

            min-height: 100vh;

        }

        /* Container for the entire chart to center it */

        .org-chart-page-container {

            flex-grow: 1; /* Allows it to take up available space */

            display: flex;

            justify-content: center;

            align-items: flex-start; /* Align chart to the top */

            padding: 30px;

            overflow-x: auto; /* Allows horizontal scrolling if chart is too wide */

            background-color: #f7f7f7;

        }



        /* Main Chart Area - with the light green gradient background */

        .org-chart {

            background: linear-gradient(to bottom, #e0ffe0, #c0ffc0); /* Light green gradient */

            border-radius: 10px;

            padding: 40px;

            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);

            display: flex;

            flex-direction: column;

            align-items: center;

            min-width: 900px; /* Adjust as needed for the content width */

            max-width: 1200px; /* Max width to keep it from getting too wide */

        }



        /* Header Logos */

        .chart-header-logos {

            display: flex;

            justify-content: space-between;

            width: 100%;

            margin-bottom: 20px;

            padding: 0 50px; /* Push logos inward from edges */

        }



        .chart-header-logos img {

            height: 60px; /* Adjust size as needed */

            object-fit: contain; /* Ensures logo fits without cropping */

        }



        /* Chart Title and Subtitle */

        .chart-title-text {

            text-align: center;

            margin-bottom: 25px;

        }



        .chart-title-text h2 {

            font-size: 2.2rem;

            font-weight: bold;

            color: #333;

            margin: 0;

            line-height: 1.2;

        }



        .chart-title-text h3 {

            font-size: 1.3rem;

            font-weight: normal;

            color: #555;

            margin: 5px 0 0 0;

        }



        /* Common Node Styling */

        .node {

            background-color: #fff;

            border: 1px solid #00a0a0; /* Teal border */

            border-radius: 8px;

            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);

            padding: 10px 15px;

            margin: 10px;

            text-align: center;

            position: relative; /* For connectors */

            min-width: 150px; /* Ensure nodes have a minimum width */

        }



        .node-img {

            width: 80px;

            height: 80px;

            border-radius: 50%; /* Circular image */

            object-fit: cover; /* Ensures image fills the circle */

            border: 3px solid #00a0a0; /* Teal border for profile pics */

            margin-bottom: 8px;

        }



        .node-name {

            font-weight: bold;

            font-size: 1rem;

            color: #333;

            margin-bottom: 2px;

        }



        .node-position {

            font-size: 0.85rem;

            color: #666;

            line-height: 1.2;

        }



        /* Specific styles for the top (City Nutrition Action Officer) node */

        .top-node .node-position {

            background-color: #fffacd; /* Light yellow background */

            border: 1px solid #e0c240; /* Slightly darker border */

            border-radius: 5px;

            padding: 5px 10px;

            font-weight: bold;

            color: #333;

            margin-top: 5px;

        }



        /* Connector Lines */

        .connector-line {

            background-color: #666; /* Gray line color */

            position: absolute;

        }



        .vertical-line {

            width: 2px;

            height: 30px; /* Length of vertical line */

            margin: 0 auto;

            background-color: #666;

        }



        /* Division Boxes (Technical, Administrative) */

        .division-line-container {

            display: flex;

            justify-content: center;

            width: 100%;

            position: relative;

            margin-top: 10px;

        }

        

        .division-line-container::before {

            content: '';

            position: absolute;

            top: 0;

            left: 50%;

            transform: translateX(-50%);

            width: 70%; /* Horizontal line span */

            height: 2px;

            background-color: #666;

        }



        .division-box {

            background-color: #fff;

            border: 1px solid #666;

            border-top: none; /* No top border */

            border-radius: 0 0 8px 8px;

            padding: 8px 30px;

            margin: 0 30px; /* Spacing between division boxes */

            font-weight: bold;

            color: #333;

            position: relative;

            z-index: 1; /* Ensure box is above the horizontal line */

            top: -1px; /* Overlap with the horizontal line */

        }



        /* Member Grouping */

        .division-group {

            display: flex;

            justify-content: center;

            margin-top: 20px;

            width: 100%;

        }



        .technical-division, .administrative-division {

            display: flex;

            flex-direction: column;

            align-items: center;

            flex: 1; /* Takes equal space */

            padding: 0 10px; /* Padding for inner spacing */

        }



        .technical-members, .administrative-members {

            display: flex;

            justify-content: center;

            gap: 20px; /* Space between member nodes */

            margin-top: 20px; /* Space from division box */

            position: relative;

        }



        /* Horizontal line above members */

        .technical-members::before,

        .administrative-members::before {

            content: '';

            position: absolute;

            top: -10px; /* Position above nodes */

            left: 0;

            right: 0;

            height: 2px;

            background-color: #666;

        }



        /* Vertical lines connecting to individual members */

        .member-container {

            display: flex;

            flex-direction: column;

            align-items: center;

            position: relative;

            padding-top: 15px; /* Space for the vertical line */

        }

        

        .member-container::before {

            content: '';

            position: absolute;

            top: 0; /* Starts at the horizontal line */

            left: 50%;

            transform: translateX(-50%);

            width: 2px;

            height: 15px; /* Length of individual vertical line */

            background-color: #666;

        }

        

        /* Footer (from your previous code, integrated) */

        .footer {

            background-color: #1f2937; /* gray-800 */

            color: #d1d5db; /* gray-300 */

            padding: 2.5rem 0;

            margin-top: auto;

            position: relative;

            z-index: 10;

        }



        .footer-container {

            max-width: 72rem;

            margin: 0 auto;

            padding: 0 1rem;

        }



        .footer-grid {

            display: grid;

            grid-template-columns: 1fr;

            gap: 2rem;

        }



        @media (min-width: 768px) {

            .footer-grid {

                grid-template-columns: repeat(5, 1fr);

            }

            .footer-logo-col { /* Adjusting based on your previous footer grid */

                grid-column: span 2 / span 2;

            }

        }



        .footer-logo-container { /* Renamed from .footer-logo to avoid conflict and be more specific */

            display: flex;

            flex-direction: column;

            align-items: flex-start;

        }

        

        /* Specific styling for the logo within the footer-logo-container */

        .footer-logo-content { /* New wrapper for img and logo-text */

            display: flex;

            align-items: center;

            margin-bottom: 1rem;

        }



        .footer-logo-img { /* Applied to the actual <img> in footer */

            height: 2.5rem;

            width: 2.5rem;

            margin-right: 0.5rem;

            border-radius: 0.5rem;

        }



        .logo-text-footer { /* New class for footer text to avoid header conflicts */

            display: flex;

            align-items: center;

            font-size: 1.5rem;

            font-weight: bold;

        }



        .logo-primary-footer {

            color: #00a0a0;

        }



        .logo-secondary-footer {

            color: #fff;

            margin-left: 0.25rem;

        }



        .footer-desc {

            font-size: 0.875rem;

        }



        .footer-title {

            font-size: 1.125rem;

            font-weight: 600;

            color: #fff;

            margin-bottom: 1rem;

        }



        .footer-links {

            list-style: none;

            padding: 0;

            margin: 0;

        }



        .footer-links li {

            margin-bottom: 0.5rem;

        }



        .footer-links a {

            color: #d1d5db;

            text-decoration: none;

            transition: color 0.2s;

        }



        .footer-links a:hover {

            color: #00a0a0;

        }



        .footer-bottom {

            margin-top: 2rem;

            border-top: 1px solid #374151; /* gray-700 */

            padding-top: 2rem;

            text-align: center;

        }



        .footer-bottom p {

            color: #9ca3af; /* gray-400 */

            font-size: 0.875rem;

        }

    </style>
</head>
<body>

    <header class="header">
        <div class="logo-container">
            <img src="../../img/CNO_Logo.jpg" alt="CNO NutriMap Logo" class="logo-img">
            <span class="logo-text-primary">CNO</span>
            <span class="logo-text-secondary">NutriMap</span>
        </div>
        <div class="org-chart-page-container">

        <div class="org-chart">

            <div class="chart-header-logos">

                <img src="../../img/Ellipse_04.png" alt="Bagong Pilipinas Logo">

                <img src="../../img/Ellipse_02.png" alt="El Salvador City Logo">

            </div>



            <div class="chart-title-text">

                <h2>ORGANIZATIONAL CHART</h2>

                <h2>CITY NUTRITION OFFICE</h2>

                <h3>El Salvador City, Misamis Oriental</h3>

            </div>



            <div class="node top-node">

                <img src="../../img/CNAO.png" alt="Elma M. Clapano, RN" class="node-img">

                <div class="node-name">Elma M. Clapano, RN</div>

                <div class="node-position">City Nutrition Action Officer</div>

            </div>



            <div class="vertical-line"></div>



            <div class="division-line-container">

                <div class="division-box">Technical Division</div>

                <div class="division-box">Administrative Division</div>

            </div>



            <div class="division-group">

                <div class="technical-division">

                    <div class="technical-members">

                        <div class="member-container">

                            <div class="node">

                                <img src="../../img/CNPC.png" alt="Edgar B. Napiñas" class="node-img">

                                <div class="node-position">City Nutrition Program Coordinator</div>

                                <div class="node-name">Edgar B. Napiñas</div>

                            </div>

                        </div>

                        <div class="member-container">

                            <div class="node">

                                <img src="../../img/CND.png" alt="Arlie Joy O. Damiles, RND" class="node-img">

                                <div class="node-position">Nutritionist-Dietitian</div>

                                <div class="node-name">Arlie Joy O. Damiles, RND</div>

                            </div>

                        </div>

                        <div class="member-container">

                            <div class="node">

                                <img src="../../img/ND.png" alt="Karen Jay B. Langala, RND" class="node-img">

                                <div class="node-position">Nutritionist-Dietitian</div>

                                <div class="node-name">Karen Jay B. Langala, RND</div>

                            </div>

                        </div>

                        <div class="member-container">

                            <div class="node">

                                <img src="../../img/PC.png" alt="Jay S. Boctot, LPT" class="node-img">

                                <div class="node-position">City Nutrition Program Coordinator</div>

                                <div class="node-name">Jay S. Boctot, LPT</div>

                            </div>

                        </div>

                    </div>

                </div>



                <div class="administrative-division">

                    <div class="administrative-members">

                        <div class="member-container">

                            <div class="node">

                                <img src="../../img/OC.png" alt="Honey Grace S. Magriña" class="node-img">

                                <div class="node-position">Office Clerk</div>

                                <div class="node-name">Honey Grace S. Magriña</div>

                            </div>

                        </div>

                        <div class="member-container">

                            <div class="node">

                                <img src="../../img/AA.png" alt="Antonette E. Villbar" class="node-img">

                                <div class="node-position">Administrative Aide III</div>

                                <div class="node-name">Antonette E. Villbar</div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    

    <footer class="footer">

        <div class="footer-container">

            <div class="footer-grid">

                <div class="footer-logo-col footer-logo-container">

                    <div class="footer-logo-content">

                        <img src="../../img/CNO_Logo.jpg" alt="CNO NutriMap Logo" class="footer-logo-img">

                        <div class="logo-text-footer">

                            <span class="logo-primary-footer">CNO</span>

                            <span class="logo-secondary-footer">NutriMap</span>

                        </div>

                    </div>

                    <p class="footer-desc">

                        A tool to visualize health and nutrition data for children in El Salvador City.

                    </p>

                </div>

                <div>

                    <h3 class="footer-title">About Us</h3>

                    <ul class="footer-links">

                        <li><a href="pages/about_us/mission.php">Our Mission</a></li>

                        <li><a href="pages/about_us/vision.php">Our Vision</a></li>

                        <li><a href="pages/about_us/history.php">History</a></li>

                    </ul>

                </div>

                <div>

                    <h3 class="footer-title">Quick Links</h3>

                    <ul class="footer-links">

                        <li><a href="pages/map_us/map.php">Map</a></li>

                        <li><a href="pages/contact_us/get_in_touch.php">Contact Us</a></li>

                        <li><a href="pages/contact_us/downloadable_form.php">Downloadable Forms</a></li>

                    </ul>

                </div>

                <div>

                    <h3 class="footer-title">Legal & Support</h3>

                    <ul class="footer-links">

                        <li><a href="pages/legal_and_support/terms_of_use.php">Terms of Use</a></li>

                        <li><a href="pages/legal_and_support/privacy_policy.php">Privacy Policy</a></li>

                        <li><a href="pages/legal_and_support/cookies.php">Cookies</a></li>

                        <li><a href="pages/help_and_support/help.php">Help</a></li>

                        <li><a href="pages/help_and_support/faqs.php">FAQs</a></li>

                    </ul>

                </div>

            </div>

            <div class="footer-bottom">

                <p>Copyright&copy; 2025 CNO NutriMap All Rights Reserved. Developed By NBSC ICS 4th Year Student.</p>

            </div>

        </div>

    </footer>



</body>

</html>