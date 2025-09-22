<?php
// sidemenu.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../db/config.php';

// ✅ Allow only CNO users
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'BNS') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ✅ Fetch user info
$stmt = $pdo->prepare("SELECT first_name, last_name, barangay FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$user_name = $user ? htmlspecialchars($user['first_name'] . " " . $user['last_name']) : "Guest";
$user_barangay = $user ? htmlspecialchars($user['barangay']) : "";
?>
<style>
/* Your existing CSS (unchanged) */
#sideMenu {
  position: fixed;
  top: 0;
  left: 0;
  width: 280px;
  height: 100%;
  background: #fff;
  box-shadow: 2px 0 8px rgba(0,0,0,0.15);
  display: flex;
  flex-direction: column;
  padding: 15px 0;
  transform: translateX(-100%);
  transition: transform 0.3s ease-in-out;
  z-index: 2000;
  font-family: 'Segoe UI', Arial, sans-serif;
}

#sideMenu.open { transform: translateX(0); }
.sideMenu-header { display: flex; align-items: center; justify-content: space-between; padding: 0 20px; margin-bottom: 20px; }
.sideMenu-header h2 { font-size: 22px; font-weight: 600; color: #009688; margin: 0; }
.sideMenu-header .close-btn { font-size: 22px; cursor: pointer; color: #555; }

.menu-links { list-style: none; padding: 0; margin: 0; }
.menu-links li {
  display: flex; align-items: center;
  padding: 12px 20px; font-size: 16px;
  cursor: pointer; transition: background 0.2s, color 0.2s;
  color: #333; border-radius: 6px; margin: 3px 10px;
}
.menu-links li:hover { background: #f0f0f0; color: #009688; }
.menu-links i { margin-right: 12px; font-size: 18px; color: #666; }

.divider { height: 1px; background: #e0e0e0; margin: 20px 0; }

.sideMenu-footer { margin-top: auto; padding: 0 20px 15px 20px; }
.user-info {
  display: flex; align-items: center; gap: 12px;
  margin-bottom: 10px; padding-bottom: 10px;
  border-bottom: 1px solid #e0e0e0; cursor: pointer;
}
.user-info img {
  width: 40px; height: 40px;
  border-radius: 50%; object-fit: cover;
}
.footer-links a {
  display: flex; align-items: center; gap: 10px;
  text-decoration: none; color: #555; font-size: 15px;
  padding: 8px 0; transition: color 0.2s;
}
.footer-links a:hover { color: #009688; }

.settings-dropdown { flex-direction: column; align-items: stretch; }
.settings-btn { display: flex; align-items: center; justify-content: space-between; width: 100%; }
.settings-btn i:last-child { margin-left: auto; transition: transform 0.2s ease; }
.settings-btn.open i:last-child { transform: rotate(180deg); }

#settingsMenu { list-style: none; padding: 0; margin: 0; display: none; flex-direction: column; }
#settingsMenu li {
  padding: 10px 40px;
  cursor: pointer; font-size: 15px; color: #333;
  display: flex; align-items: center; gap: 12px;
  transition: background 0.2s, color 0.2s;
}
#settingsMenu li:hover { background: #f5f5f5; color: #009688; }
#settingsMenu li i { font-size: 16px; color: #666; }
</style>

<div id="sideMenu">
  <div class="sideMenu-header">
    <h2>CNO</h2>
    <span class="close-btn">&times;</span>
  </div>

  <ul class="menu-links">
    <li data-url="home.php"><i class="fa fa-home"></i> Home</li>
    <li data-url="reports.php"><i class="fa fa-file-alt"></i> Reports</li>
    <li data-url="report_history.php"><i class="fa fa-history"></i> Report History</li>
    <li data-url="barangay_data.php"><i class="fa fa-database"></i> Barangay Data</li>

    <!-- Settings dropdown -->
    <li class="settings-dropdown">
      <div class="settings-btn" id="settingsBtn">
        <span><i class="fa fa-cog"></i> Settings</span>
        <i class="fa fa-chevron-down"></i>
      </div>
      <ul id="settingsMenu">
        <li data-url="archive.php"><i class="fa fa-archive"></i> Archive</li>
        <li data-url="security.php"><i class="fa fa-shield-alt"></i> Security</li>
      </ul>
    </li>
  </ul>

  <div class="divider"></div>

  <div class="sideMenu-footer">
    <div class="user-info" id="userProfileBtn">
      <img src="../uploads/profile_placeholder.png" alt="User">
      <span><?php echo $user_name; ?></span>
    </div>
    <div class="footer-links">
      <a href="../index.php"><i class="fa fa-sign-out-alt"></i> Sign Out</a>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const userProfileBtn = document.getElementById('userProfileBtn');
  if (userProfileBtn) {
    userProfileBtn.addEventListener('click', () => {
      window.location.href = 'profile.php';
    });
  }

  // Settings dropdown toggle
  const settingsBtn = document.getElementById('settingsBtn');
  const settingsMenu = document.getElementById('settingsMenu');
  if (settingsBtn) {
    settingsBtn.addEventListener('click', () => {
      settingsBtn.classList.toggle('open');
      settingsMenu.style.display = settingsMenu.style.display === 'flex' ? 'none' : 'flex';
    });
  }
});
</script>
