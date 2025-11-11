<?php
session_start();
require 'db/config.php';
require 'otp/mailer.php';

$error = '';
$rememberedEmail = isset($_COOKIE['remember_email']) ? $_COOKIE['remember_email'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $remember = isset($_POST['remember']);

    if (!empty($email) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
        $stmt->execute([$email, $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            if ($remember) {
                setcookie('remember_email', $email, time() + (7*24*60*60), "/");
            } else {
                setcookie('remember_email', '', time() - 3600, "/");
            }
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_type'] = $user['user_type'];
            $_SESSION['barangay'] = $user['barangay']; 
            header("Location: " . ($user['user_type'] === 'CNO' ? "cno/home.php" : "bns/home.php"));
            exit();
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome for Eye Icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

  <!-- Brand header -->
  <div class="bg-white shadow py-4 px-6 md:px-10 text-2xl font-bold text-gray-800">
    <span class="text-teal-500">CNO</span> NutriMap
  </div>

  <!-- Main container -->
  <div class="flex flex-1 flex-col md:flex-row">

    <!-- Left panel: Login Form -->
    <div class="md:w-1/2 flex justify-center items-center p-6">
      <div class="w-full max-w-md bg-white shadow-md rounded-lg p-8">
        <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Login</h2>

        <?php if (!empty($error)): ?>
          <p class="text-red-500 text-center mb-4"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
          <input type="text" name="email" placeholder="Email or Username" 
                 value="<?= htmlspecialchars($rememberedEmail) ?>"
                 class="w-full px-4 py-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400" required>

          <div class="relative">
            <input type="password" id="password" name="password" placeholder="Password"
                   class="w-full px-4 py-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400 pr-10" required>
            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-600" onclick="togglePassword()">
              <i id="eyeIcon" class="fa-solid fa-eye"></i>
            </span>
          </div>

          <button type="submit" class="w-full bg-teal-500 text-white py-3 rounded-md font-bold hover:bg-teal-600 transition-colors">
            Log In
          </button>

          <div class="flex justify-between items-center text-sm text-gray-600">
            <label class="flex items-center gap-2">
              <input type="checkbox" name="remember" <?= isset($_COOKIE['remember_email']) ? 'checked' : '' ?> class="h-4 w-4 rounded border-gray-300">
              Remember me
            </label>
            <a href="index.php" class="text-teal-500 font-semibold hover:underline">Just Visit!</a>
          </div>
        </form>
      </div>
    </div>

    <!-- Right panel: Illustration -->
    <div class="md:w-1/2 flex justify-center items-center p-6 bg-teal-50">
      <img src="img/nutritional.png" alt="Nutrition Illustration" class="max-w-full h-auto rounded-lg shadow-md">
    </div>
  </div>

  <!-- Password toggle script -->
  <script>
    function togglePassword() {
      const passwordField = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');
      if(passwordField.type === "password"){
        passwordField.type = "text";
        eyeIcon.classList.replace("fa-eye", "fa-eye-slash");
      } else {
        passwordField.type = "password";
        eyeIcon.classList.replace("fa-eye-slash", "fa-eye");
      }
    }
  </script>

</body>
</html>
