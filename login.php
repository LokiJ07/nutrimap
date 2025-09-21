<?php
session_start();
require 'db/config.php';
require 'otp/mailer.php';

$error = '';

// ✅ If "Remember Me" cookies exist, auto-fill email
if (isset($_COOKIE['remember_email'])) {
    $rememberedEmail = $_COOKIE['remember_email'];
} else {
    $rememberedEmail = '';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $remember = isset($_POST['remember']); // ✅ Capture remember me checkbox

    if (!empty($email) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
        $stmt->execute([$email, $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {

            // ✅ Save Remember Me cookie for 7 days if checked
            if ($remember) {
                setcookie('remember_email', $email, time() + (7 * 24 * 60 * 60), "/");
            } else {
                setcookie('remember_email', '', time() - 3600, "/"); // Clear if unchecked
            }

            // ✅ Generate OTP
            $otp = rand(100000, 999999);
            $expires = date("Y-m-d H:i:s", strtotime("+5 minutes"));

            $stmt = $pdo->prepare("INSERT INTO otp_codes (user_id, otp_code, expires_at) VALUES (?, ?, ?)");
            $stmt->execute([$user['id'], $otp, $expires]);

            // ✅ Save user info temporarily until OTP verification
            $_SESSION['pending_user_id']    = $user['id'];
            $_SESSION['pending_user_type']  = $user['user_type'];
            $_SESSION['pending_first_name'] = $user['first_name'];
            $_SESSION['pending_user_email'] = $user['email']; 
            $_SESSION['pending_barangay']   = $user['barangay']; // ✅ save barangay

            if (sendOTP($user['email'], $otp)) {
                $_SESSION['otp_message'] = "We sent a One-Time Password (OTP) to your email.";
            } else {
                $_SESSION['otp_message'] = "Failed to send OTP email. Please contact admin.";
            }

            header("Location: otp/verify_otp.php");
            exit;
        } else {
            $error = "Invalid email/username or password!";
        }
    } else {
        $error = "All fields are required!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CNO NutriMap - Login</title>
  <!-- ✅ Font Awesome for Eye Icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #d3d3d3;
      display: flex;
      flex-direction: column;
      height: 100vh;
    }

    /* Top brand header */
    .brand {
      font-weight: bold;
      font-size: 22px; /* Slightly bigger */
      padding: 20px 40px;
    }

    .brand span {
      color: #00AEEF;
    }

    /* Main container split */
    .container {
      flex: 1;
      display: flex;
    }

    .left-panel {
      width: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-box {
      width: 360px; /* Slightly bigger box */
    }

    .login-box h2 {
      margin-bottom: 25px;
      font-size: 26px;
      font-weight: bold;
      color: #000;
    }

    .login-box input {
      width: 100%;
      padding: 14px;
      margin-bottom: 18px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 15px;
      background: #fff;
      box-sizing: border-box;
    }

    .password-wrapper {
      position: relative;
    }

    .password-wrapper input {
      padding-right: 40px;
    }

    .toggle-password {
      position: absolute;
      top: 40%;
      right: 12px;
      transform: translateY(-50%);
      cursor: pointer;
      font-size: 18px;
      color: #555;
    }

    .login-box button {
      width: 100%;
      padding: 14px;
      background: #008080;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
    }

    .login-box button:hover {
      background: #006666;
    }

    .options {
      margin-top: 12px;
      font-size: 14px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 10px;
    }

    .options label {
      display: flex;
      align-items: center;
      gap: 5px;
      font-size: 14px;
    }

    .options a {
      text-decoration: none;
      color: #00AEEF;
      font-weight: bold;
    }

    .error {
      color: red;
      font-size: 15px;
      margin-bottom: 12px;
      text-align: center;
    }

    .right-panel {
      width: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .right-panel img {
      max-width: 85%;
      height: auto;
    }
  </style>
</head>
<body>

  <!-- Top brand -->
  <div class="brand"><span>CNO</span> NutriMap</div>

  <!-- Split panels -->
  <div class="container">
    <!-- Left login form -->
    <div class="left-panel">
      <div class="login-box">
        <h2>LOGIN</h2>

        <?php if (!empty($error)): ?>
          <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <form method="POST">
          <input type="text" name="email" placeholder="Enter Email" value="<?= htmlspecialchars($rememberedEmail) ?>" required>

          <div class="password-wrapper">
            <input type="password" id="password" name="password" placeholder="Enter Password" required>
            <!-- ✅ Replaced 👁 with Font Awesome Eye -->
            <span class="toggle-password" onclick="togglePassword()">
              <i id="eyeIcon" class="fa-solid fa-eye"></i>
            </span>
          </div>

          <button type="submit">Log in</button>

          <div class="options">
            <label><input type="checkbox" name="remember" <?= isset($_COOKIE['remember_email']) ? 'checked' : '' ?>> Remember me!</label>
            <a href="index.php">Just visit!</a>
          </div>
        </form>
      </div>
    </div>

    <!-- Right illustration -->
    <div class="right-panel">
      <img src="img/nutritional.png" alt="Nutrition Illustration">
    </div>
  </div>

  <script>
    function togglePassword() {
      const passwordField = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');

      if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
      } else {
        passwordField.type = "password";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
      }
    }
  </script>

</body>
</html>
