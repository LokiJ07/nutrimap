<?php
session_start();
require 'db/config.php';
require 'otp/mailer.php';

$error = '';

// ✅ If "Remember Me" cookies exist, auto-fill email
$rememberedEmail = isset($_COOKIE['remember_email']) ? $_COOKIE['remember_email'] : '';

// ✅ Activity log function
function logActivity($pdo, $user_id, $action, $details = null) {
    $stmt = $pdo->prepare("INSERT INTO activity_logs (user_id, action, details) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $action, $details]);
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

            // ✅ Generate or retrieve device token
            if (empty($_COOKIE['device_token'])) {
                $device_token = bin2hex(random_bytes(16));
                setcookie('device_token', $device_token, time() + (365 * 24 * 60 * 60), "/"); // 1 year
            } else {
                $device_token = $_COOKIE['device_token'];
            }

            // ✅ Check if this device is already trusted
            $checkDevice = $pdo->prepare("
                SELECT id, session_id FROM login_history 
                WHERE user_id = ? AND device_token = ? 
                LIMIT 1
            ");
            $checkDevice->execute([$user['id'], $device_token]);
            $existingDevice = $checkDevice->fetch(PDO::FETCH_ASSOC);

            $session_id = session_id();
            $browser = $_SERVER['HTTP_USER_AGENT'];
            $ip = $_SERVER['REMOTE_ADDR'];

            if ($existingDevice) {
                // ✅ Trusted device → skip OTP and log in directly
                $_SESSION['user_id']    = $user['id'];
                $_SESSION['user_type']  = $user['user_type'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['email']      = $user['email'];
                $_SESSION['barangay']   = $user['barangay'];

                // ✅ Update login time & session id
                $update = $pdo->prepare("UPDATE login_history SET login_time = NOW(), logout_time = NULL, session_id = ? WHERE id = ?");
                $update->execute([$session_id, $existingDevice['id']]);

                // ✅ Save current session in users table
                $pdo->prepare("UPDATE users SET current_session = ? WHERE id = ?")
                    ->execute([$session_id, $user['id']]);

                // ✅ Log activity
                logActivity($pdo, $user['id'], "User logged in", "Trusted device login from IP $ip");

                // Redirect based on role
                if ($user['user_type'] === 'CNO') {
                    header("Location: cno/home.php");
                } else {
                    header("Location: bns/home.php");
                }
                exit();

            } else {
                // ✅ New device → send OTP and save as pending
                $historyStmt = $pdo->prepare("
                    INSERT INTO login_history (user_id, session_id, browser, ip_address, device_token, login_time)
                    VALUES (?, ?, ?, ?, ?, NOW())
                ");
                $historyStmt->execute([$user['id'], $session_id, $browser, $ip, $device_token]);

                // ✅ Save current session in users table for reference
                $pdo->prepare("UPDATE users SET current_session = ? WHERE id = ?")
                    ->execute([$session_id, $user['id']]);

                // ✅ Generate OTP
                $otp = rand(100000, 999999);
                $expires = date("Y-m-d H:i:s", strtotime("+5 minutes"));

                $stmt = $pdo->prepare("INSERT INTO otp_codes (user_id, otp_code, expires_at) VALUES (?, ?, ?)");
                $stmt->execute([$user['id'], $otp, $expires]);

                // ✅ Save user info temporarily until OTP verification
                $_SESSION['pending_user_id']      = $user['id'];
                $_SESSION['pending_user_type']    = $user['user_type'];
                $_SESSION['pending_first_name']   = $user['first_name'];
                $_SESSION['pending_user_email']   = $user['email'];
                $_SESSION['pending_barangay']     = $user['barangay'];
                $_SESSION['pending_device_token'] = $device_token;

                // ✅ Log activity for new device
                logActivity($pdo, $user['id'], "OTP sent for new device login", "Device token: $device_token, IP: $ip");

                if (sendOTP($user['email'], $otp)) {
                    $_SESSION['otp_message'] = "We sent a One-Time Password (OTP) to your email.";
                } else {
                    $_SESSION['otp_message'] = "Failed to send OTP email. Please contact admin.";
                }

                header("Location: otp/verify_otp.php");
                exit;
            }

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
