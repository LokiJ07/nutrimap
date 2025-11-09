<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>CNO NutriMap | Contact Us</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../../../img/CNO_Logo.png">
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
  .container {
      max-width: 1100px;
      margin: 40px auto;
      padding: 0 20px;
    }

    /* Contact Card */
    .contact-card {
      display: flex;
      flex-wrap: wrap;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
      overflow: hidden;
      margin-bottom: 20px;
    }

    .contact-info {
      flex: 1 1 350px;
      padding: 30px;
    }

    .contact-info h2 {
      font-size: 22px;
      font-weight: 600;
      margin-bottom: 25px;
      color: #000;
    }

    .info-item {
      margin-bottom: 20px;
    }

    .info-item i {
      color: #00bfff;
      margin-right: 10px;
      font-size: 18px;
    }

    .info-item h4 {
      font-size: 14px;
      font-weight: 600;
      color: #111;
    }

    .info-item p {
      font-size: 15px;
      color: #555;
      margin-top: 3px;
    }

    .map {
      flex: 1 1 350px;
      min-height: 300px;
    }

    .map iframe {
      width: 100%;
      height: 100%;
      border: none;
    }

    /* Bottom Contact Boxes */
    .bottom-contact {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin-top: 10px;
    }

    .contact-box {
      flex: 1 1 350px;
      background: #fff;
      border-radius: 8px;
      display: flex;
      align-items: center;
      gap: 15px;
      padding: 15px 20px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.32);
    }

    .contact-box i {
      color: #00bfff;
      font-size: 20px;
    }

    .contact-box p {
      font-size: 15px;
      color: #333;
      line-height: 1.4;
    }

    .contact-box span {
      display: block;
      font-size: 13px;
      color: #666;
    }

    /* Message Card */
    .message-card {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
      margin-top: 30px;
      padding: 30px;
    }

    .message-card h2 {
      font-size: 22px;
      font-weight: 600;
      margin-bottom: 20px;
      color: #000;
    }

    .message-card form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .message-card input,
    .message-card textarea {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 15px;
      outline: none;
      transition: 0.2s;
    }

    .message-card input:focus,
    .message-card textarea:focus {
      border-color: #00bfff;
      box-shadow: 0 0 4px rgba(0, 191, 255, 0.3);
    }

    .message-card textarea {
      min-height: 120px;
      resize: vertical;
    }

    .message-card button {
      align-self: flex-start;
      background: #00bfff;
      color: #fff;
      border: none;
      padding: 12px 25px;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s;
    }

    .message-card button:hover {
      background: #0099cc;
    }

    .success-msg {
      color: green;
      margin-bottom: 10px;
      transition: opacity 0.5s ease;
    }

    .error-msg {
      color: red;
      margin-bottom: 10px;
    }

    /* Footer */
    footer {
      background-color: #013241;
      color: #f9f9f9;
      padding: 80px 80px 20px;
      text-align: left;
      position: relative;
      z-index: 1;
      margin-top: 60px;
    }

    .footer-container {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 40px;
      margin-bottom: 40px;
    }

    .footer-logo h2 {
      font-size: 22px;
      font-weight: 700;
    }

    .footer-logo span {
      color: #00b3b3;
    }

    .footer-about {
      max-width: 400px;
    }

    .footer-about p {
      margin-top: 10px;
      font-size: 15px;
      line-height: 1.6;
      color: #ddd;
    }

    .footer-contact h3,
    .footer-social h3 {
      color: #00e0d1;
      font-size: 18px;
      margin-bottom: 10px;
    }

    .footer-contact p {
      font-size: 15px;
      margin-bottom: 5px;
      color: #ccc;
    }

    .footer-social a {
      color: #00b3b3;
      font-size: 20px;
      margin-right: 15px;
      text-decoration: none;
      transition: 0.3s;
    }

    .footer-social a:hover {
      color: #00e0d1;
    }

    .footer-bottom {
      border-top: 1px solid #333;
      text-align: center;
      padding-top: 15px;
      font-size: 14px;
      color: #aaa;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .contact-card {
        flex-direction: column;
      }
      .map {
        height: 250px;
      }
      footer {
        padding: 40px 20px 15px;
      }
    }
    </style>
</head>
<body class="flex flex-col min-h-screen bg-gray-100 text-gray-800">

    <!-- Header Section -->
           <header class="header">
        <div class="logo">
            <img src="../../../img/CNO_Logo.png" alt="CNO NutriMap Logo">
            <span class="cno-color">CNO</span><span class="logo-space"></span><span>NutriMap</span>
        </div>
        <nav class="nav">
            <a href="../../../index.php" class="nav-link">Home</a>
            <a href="../../../landing_page/map.php" class="nav-link">Map</a>
            <div class="dropdown">
                <a href="../about_us/about.php" class="nav-link dropdown-link">About CNO <svg class="dropdown-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></a>
                <div class="dropdown-content">
                    <a href="../about_us/profile.php">Profile <i class="fas fa-caret-right"></i></a>
                    <a href="../about_us/history.php">History <i class="fas fa-caret-right"></i></a>
                    <a href="../about_us/vision.php">Vision <i class="fas fa-caret-right"></i></a>
                    <a href="../about_us/mission.php">Mission <i class="fas fa-caret-right"></i></a>
                </div>
            </div>
            <a href="landing_page/pages/contact_us/contact.php" class="nav-link home-btn">Contact Us</a>
            <a href="../../../login.php" class="nav-link login-btn">Login</a>
        </nav>
    </header>

    <!-- Main Content -->
 <?php
  $successMsg = "";
  $errorMsg = "";

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
      $name = trim($_POST['name']);
      $email = trim($_POST['email']);
      $message = trim($_POST['message']);

      if (!empty($name) && !empty($email) && !empty($message)) {
          $to = "danmarkpetalcurin@gmail.com"; // Admin/CNO email
          $subject = "New Message from Guest User - $name";

          $body = "
              <h3>Message form the guest user of CNO nutrimap</h3>
              <p><strong>Name:</strong> " . htmlspecialchars($name) . "</p>
              <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
              <p><strong>Message:</strong><br>" . nl2br(htmlspecialchars($message)) . "</p>
              <hr>
              <p>This message was sent via the CNO NutriMap Contact Form.</p>
          ";

          if (sendEmailNotification($to, $subject, $body)) {
              $successMsg = "Message sent successfully!";
          } else {
              $errorMsg = "Failed to send message. Please try again later.";
          }
      } else {
          $errorMsg = "All fields are required.";
      }
  }
  ?>

  <div class="container">
    <!-- Contact Information Card -->
    <div class="contact-card">
      <div class="contact-info">
        <h2>Contact Information</h2>

        <div class="info-item">
          <i class="fa-solid fa-location-dot"></i>
          <h4>Address</h4>
          <p>Poblacion, El Salvador, Philippines, 9017</p>
        </div>

        <div class="info-item">
          <i class="fa-solid fa-map-location"></i>
          <h4>Service area</h4>
          <p>El Salvador, Philippines</p>
        </div>

        <div class="info-item">
          <i class="fa-solid fa-calendar-days"></i>
          <h4>Open Days</h4>
          <p>Monday to Friday</p>
        </div>

        <div class="info-item">
          <i class="fa-regular fa-clock"></i>
          <h4>Open/Closing Hours</h4>
          <p>08:00 am - 17:00 pm</p>
        </div>
      </div>

      <!-- Map Section -->
      <div class="map">
        <iframe
          src="https://www.google.com/maps?q=El%20Salvador%20Misamis%20Oriental&output=embed"
          allowfullscreen=""
          loading="lazy">
        </iframe>
      </div>
    </div>

    <!-- Contact Details Boxes -->
    <div class="bottom-contact">
      <div class="contact-box">
        <i class="fa-solid fa-phone"></i>
        <div>
          <p>0917 713 2398</p>
          <span>Mobile</span>
        </div>
      </div>

      <div class="contact-box">
        <i class="fa-solid fa-envelope"></i>
        <div>
          <p>citynutritionoffice@elsalvadorcity.gov.ph</p>
          <span>Email</span>
        </div>
      </div>
    </div>

    <!-- Message Card -->
    <div class="message-card">
      <h2>Send Us a Message</h2>

      <?php if (!empty($successMsg)) echo "<p class='success-msg' id='successMsg'>$successMsg</p>"; ?>
      <?php if (!empty($errorMsg)) echo "<p class='error-msg'>$errorMsg</p>"; ?>

      <form method="POST" action="">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <textarea name="message" placeholder="Write your message here..." required></textarea>
        <button type="submit" name="send_message">Send</button>
      </form>
    </div>
  </div>

  <!-- Footer Section -->
  <footer>
    <div class="footer-container">
      <div class="footer-logo">
        <h2><span>CNO</span> NutriMap</h2>
        <div class="footer-about">
          <p>
            Dedicated to improving the nutritional health of our community through
            data-driven insights, collaboration, and sustainable nutrition programs.
          </p>
        </div>
      </div>

      <div class="footer-contact">
        <h3>Contact Us</h3>
        <p><i class="fa-solid fa-location-dot"></i> El Salvador, Misamis Oriental</p>
        <p><i class="fa-solid fa-envelope"></i> danmarkpetalcurin@gmail.com</p>
        <p><i class="fa-solid fa-phone"></i> +63 912 345 6789</p>
      </div>

      <div class="footer-social">
        <h3>Follow Us</h3>
        <a href="#"><i class="fab fa-facebook"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
      </div>
    </div>

    <div class="footer-bottom">
      <p>&copy; 2025 City Nutrition Office | All Rights Reserved.</p>
    </div>
  </footer>

  <!-- ✅ Added JavaScript -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const msg = document.getElementById("successMsg");
      if (msg) {
        setTimeout(() => {
          msg.style.opacity = "0";
          setTimeout(() => msg.remove(), 500);
        }, 10000); // 10 seconds
      }
    });
  </script>


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
