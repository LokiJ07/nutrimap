<?php
session_start();
require '../db/config.php';
require 'mailer.php'; 

if (!isset($_SESSION['pending_user_id'])) {
    header("Location: login.php");
    exit;
}

$error = '';
$user_id = $_SESSION['pending_user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['resend'])) {
        // ✅ Generate new OTP for Resend
        $otp = rand(100000, 999999);
        $expires = date("Y-m-d H:i:s", strtotime("+5 minutes"));

        $stmt = $pdo->prepare("INSERT INTO otp_codes (user_id, otp_code, expires_at) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $otp, $expires]);

        // Send OTP
        sendOTP($_SESSION['pending_user_email'], $otp);
        $_SESSION['otp_message'] = "A new OTP has been sent to your email.";
    } else {
        $otp = trim($_POST['otp']);

        $stmt = $pdo->prepare("SELECT * FROM otp_codes WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([$user_id]);
        $code = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($code && $code['otp_code'] === $otp && strtotime($code['expires_at']) > time()) {
            // ✅ OTP verified → finalize login session
            $_SESSION['user_id']   = $user_id;
            $_SESSION['user_type'] = $_SESSION['pending_user_type'];
            $_SESSION['first_name'] = $_SESSION['pending_first_name'];
            $_SESSION['email']     = $_SESSION['pending_user_email'];
            $_SESSION['barangay']  = $_SESSION['pending_barangay']; // ✅ barangay saved

            // optional: save username if needed
            if (isset($_SESSION['pending_username'])) {
                $_SESSION['username'] = $_SESSION['pending_username'];
            }

            // ✅ clear pending values
            unset(
                $_SESSION['pending_user_id'], 
                $_SESSION['pending_user_type'], 
                $_SESSION['pending_first_name'], 
                $_SESSION['pending_user_email'],
                $_SESSION['pending_barangay'],
                $_SESSION['pending_username']
            );

            // ✅ redirect based on role
            if ($_SESSION['user_type'] === 'CNO') {
                header("Location: ../cno/home.php");
            } else {
                header("Location: ../bns/home.php");
            }
            exit;
        } else {
            $error = "Invalid or expired OTP!";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Verify OTP</title>
</head>
<body style="margin:0; font-family: Arial, sans-serif; background:#fff; display:flex; justify-content:center; align-items:center; height:100vh;">
  <div style="background:#f9f9f9; padding:30px; border-radius:10px; width:300px; box-shadow:0 0 10px rgba(0,0,0,0.1); text-align:center;">
    <h2 style="margin-bottom:15px;">Enter OTP</h2>
    <?php if (isset($_SESSION['otp_message'])): ?>
      <p style="color:green;"><?php echo $_SESSION['otp_message']; ?></p>
      <?php unset($_SESSION['otp_message']); ?>
    <?php endif; ?>
    <?php if ($error): ?>
      <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">
      <input type="text" name="otp" maxlength="6" placeholder="Enter OTP"
             style="width:100%; padding:10px; margin-bottom:15px; border:1px solid #ccc; border-radius:5px; text-align:center; font-size:16px;" required>
      <button type="submit" style="width:100%; padding:10px; background:#28a745; color:white; border:none; border-radius:5px; font-size:15px; cursor:pointer;">
        Verify
      </button>
    </form>

    <!-- ✅ Resend OTP button -->
    <form method="POST" style="margin-top:15px;">
      <button type="submit" name="resend" style="width:100%; padding:10px; background:#007BFF; color:white; border:none; border-radius:5px; font-size:15px; cursor:pointer;">
        Resend OTP
      </button>
    </form>
  </div>
</body>
</html>
