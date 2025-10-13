<?php
session_start();
require '../db/config.php';

// ✅ Require login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ✅ Fetch login history for current user (latest first)
$stmt = $pdo->prepare("SELECT id, browser, ip_address, login_time, logout_time, session_id 
                       FROM login_history 
                       WHERE user_id = ? 
                       ORDER BY login_time DESC");
$stmt->execute([$user_id]);
$allLogins = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ✅ Filter unique devices (latest only)
$logins = [];
$seenDevices = [];

foreach ($allLogins as $login) {
    $deviceKey = $login['browser'] . '|' . $login['ip_address'];
    if (!isset($seenDevices[$deviceKey])) {
        $logins[] = $login;
        $seenDevices[$deviceKey] = true;
    }
}

// ✅ Get user info
$stmt = $pdo->prepare("SELECT password_changed, current_session, password_hash FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$password_changed = $user['password_changed'] ?? 0;
$current_session = $user['current_session'] ?? '';
$current_password_hash = $user['password_hash'] ?? '';

$password_message = '';
$password_error = false;
$show_change_password = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['current_password'], $_POST['new_password'], $_POST['confirm_password'])) {
    $show_change_password = true;
    if ($password_changed) {
        $password_message = "You have already changed your password. This action is allowed only once.";
        $password_error = true;
    } else {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if (!password_verify($current_password, $current_password_hash)) {
            $password_message = "Current password is incorrect!";
            $password_error = true;
        } elseif ($new_password !== $confirm_password) {
            $password_message = "New password and confirm password do not match!";
            $password_error = true;
        } elseif (
            strlen($new_password) < 6 || 
            !preg_match('/[0-9]/', $new_password) || 
            !preg_match('/[A-Za-z]/', $new_password)
        ) {
            $password_message = "Password must include letters and numbers.";
            $password_error = true;
        } else {
            $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $updateStmt = $pdo->prepare("UPDATE users SET password_hash = ?, password_changed = 1 WHERE id = ?");
            if ($updateStmt->execute([$new_hash, $user_id])) {
                $password_changed = 1;
                $password_message = "Password successfully changed!";
                $password_error = false;
            } else {
                $password_message = "Failed to update password. Please try again.";
                $password_error = true;
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>CNO NutriMap — Security</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body { margin:0; font-family: Arial, Helvetica, sans-serif; background:#f5f5f5; }
    .layout { display:flex; height:100vh; flex-direction:column; }
    .body-layout { flex:1; display:flex; }

    /* Sidebar */
    .sidebar {
      width:220px; background:#fff; padding:20px;
      box-shadow: 2px 0 8px rgba(0,0,0,0.1);
      display:flex; flex-direction:column; gap:15px;
    }
    .sidebar h3 { margin:0 0 10px; font-size:18px; }
    .sidebar a {
      display:flex; align-items:center; gap:10px;
      text-decoration:none; color:#000; font-size:15px;
      padding:8px; border-radius:4px;
      transition:background 0.2s;
      cursor:pointer;
    }
    .sidebar a.active, .sidebar a:hover {
      background: #00AEEF; color:#fff;
    }

    /* Content */
    .content { flex:1; padding:15px; display:flex; flex-direction:column; }
    .card {
      background:#fff; padding:20px;
      border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.1);
      display:none;
    }
    .card.active { display:block; }
    .card h2 { margin:0 0 10px; font-size:18px; }

    /* Device buttons */
    .device-btn {
      display:flex; justify-content:space-between; align-items:center;
      background:#f9f9f9; border:1px solid #ccc; border-radius:5px;
      padding:12px 14px; margin-bottom:8px;
      cursor:pointer; transition:background 0.2s;
    }
    .device-btn:hover { background:#eaeaea; }
    .device-name { font-weight:bold; font-size:15px; }
    .device-time { font-size:13px; color:#555; }

    /* Modal */
    .modal {
      display:none; 
      position:fixed; 
      top:0; left:0;
      width:100%; height:100%;
      background:rgba(0,0,0,0.5);
      justify-content:center; align-items:center;
      z-index:999;
    }
    .modal.show {
      display:flex;
    }
    .modal-content {
      background:#fff; border-radius:8px;
      width:350px; padding:20px; text-align:center;
      box-shadow:0 4px 10px rgba(0,0,0,0.3);
      position:relative;
      animation:fadeIn 0.3s ease;
    }
    @keyframes fadeIn {
      from { opacity:0; transform:scale(0.95); }
      to { opacity:1; transform:scale(1); }
    }
    .modal-content h3 { margin-bottom:10px; }
    .modal-content p { margin:8px 0; font-size:14px; }
    .modal-content button {
      margin-top:12px;
      background:#dc3545; color:#fff; border:none;
      padding:8px 12px; border-radius:4px;
      cursor:pointer;
    }
    .close-btn {
      margin-top:10px; background:#6c757d;
      color:#fff; padding:8px 12px; border:none;
      border-radius:4px; cursor:pointer;
    }

    /* Change Password */
    .password-form {
      display:flex; flex-direction:column; gap:15px; margin-top:10px;
    }
    .password-form .form-group input {
      width:100%; padding:12px 15px; font-size:15px;
      border:1px solid #ccc; border-radius:8px;
      transition: all 0.2s;
    }
    .password-form .form-group input:focus {
      border-color:#00AEEF; box-shadow:0 0 5px rgba(0,174,239,0.4);
    }
    .password-form .btn-submit {
      padding:12px; background:#0195a0ff; color:#fff; font-weight:bold;
      border:none; border-radius:8px; cursor:pointer;
      transition:background 0.2s, transform 0.1s;
    }
    .password-form .btn-submit:hover {
      background:#00AEEF; transform:translateY(-1px);
    }
    .password-message { margin-top:10px; font-size:14px; color:green; }
    .password-message.error { color:red; }
  </style>
</head>
<body>
      <?php include 'header.php'; ?>
  <div class="layout">

    <div class="body-layout">
      <!-- Sidebar -->
      <div class="sidebar">
        <h3>Security</h3>
        <a class="menu-link active" data-target="view-logins"><i class="fa-solid fa-clock-rotate-left"></i> View Logins</a>
        <a class="menu-link" data-target="change-password"><i class="fa-solid fa-lock"></i> Change Password</a>
      </div>

      <!-- Content -->
      <div class="content">
        <!-- View Logins -->
        <div class="card active" id="view-logins">
          <h2>View Logins</h2>
          <p>These are the devices where your account is logged in.</p>

          <?php if (count($logins) > 0): ?>
            <?php foreach ($logins as $login): 
              $deviceName = strtok($login['browser'], '/'); 
              $isCurrent = $login['session_id'] === $current_session;
            ?>
              <div class="device-btn">
                <span class="device-name">
                  <?= htmlspecialchars($deviceName) ?><?= $isCurrent ? " (This device)" : "" ?>
                </span>
                <span class="device-time">
                  <?= date('M j, g:i a', strtotime($login['login_time'])) ?>
                </span>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p>No logins recorded yet.</p>
          <?php endif; ?>
        </div>

        <!-- Change Password -->
        <div class="card" id="change-password">
          <h2>Change Password</h2>
          <p>You can change your password once. It must have at least 6 characters, with both letters and numbers.</p>

          <form method="post" class="password-form">
            <?php if ($password_message): ?>
              <div class="password-message <?= $password_error ? 'error' : '' ?>">
                <?= htmlspecialchars($password_message) ?>
              </div>
            <?php endif; ?>

            <?php if (!$password_changed): ?>
              <div class="form-group">
                <input type="password" name="current_password" placeholder="Current password" required>
              </div>
              <div class="form-group">
                <input type="password" name="new_password" placeholder="New password" required>
              </div>
              <div class="form-group">
                <input type="password" name="confirm_password" placeholder="Confirm new password" required>
              </div>
              <button type="submit" class="btn-submit">Change Password</button>
            <?php else: ?>
              <div class="password-message error">
                You have already changed your password. This action is allowed only once.
              </div>
            <?php endif; ?>
          </form>
        </div>
      </div>
    </div>
  </div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  // ✅ Sidebar switch
  document.querySelectorAll('.menu-link').forEach(link => {
    link.addEventListener('click', () => {
      document.querySelectorAll('.menu-link').forEach(l => l.classList.remove('active'));
      document.querySelectorAll('.card').forEach(c => c.classList.remove('active'));
      link.classList.add('active');
      document.getElementById(link.dataset.target).classList.add('active');
    });
  });

  // ✅ Keep "Change Password" active if form submitted
  <?php if (!empty($show_change_password) && $show_change_password): ?>
  document.querySelectorAll('.menu-link').forEach(l => l.classList.remove('active'));
  document.querySelectorAll('.card').forEach(c => c.classList.remove('active'));
  document.querySelector('[data-target="change-password"]').classList.add('active');
  document.getElementById('change-password').classList.add('active');
  <?php endif; ?>
});
</script>
</body>
</html>

