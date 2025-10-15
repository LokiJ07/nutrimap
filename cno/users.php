<?php
session_start();
require "../db/config.php";

// ✅ Allow only CNO users
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'CNO') {
    header("Location: ../login.php");
    exit();
}

// ✅ Handle Activate/Deactivate actions
if (isset($_GET['action'], $_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'] === 'deactivate' ? 'Inactive' : 'Active';

    $stmt = $pdo->prepare("UPDATE users SET status = ? WHERE id = ?");
    $stmt->execute([$action, $id]);

    header("Location: users.php");
    exit();
}


// Fetch Active Users
$stmt = $pdo->prepare("
    SELECT 
        id,
        CONCAT(first_name,' ',last_name) AS full_name,
        email,
        barangay,
        user_type,
        DATE_FORMAT(created_at,'%m/%d/%Y') AS created_date
    FROM users
    WHERE status = 'Active'
    ORDER BY created_at DESC
");
$stmt->execute();
$activeUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch Inactive Users
$stmt = $pdo->prepare("
    SELECT 
        id,
        CONCAT(first_name,' ',last_name) AS full_name,
        email,
        barangay,
        user_type,
        DATE_FORMAT(created_at,'%m/%d/%Y') AS created_date
    FROM users
    WHERE status = 'Inactive'
    ORDER BY created_at DESC
");
$stmt->execute();
$inactiveUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<meta charset="UTF-8">
<title>User Management</title>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f3f4f6;
    margin: 0;
    padding: 0;
}
.container {
    padding: 20px;
}
.tabs {
    border-bottom: 1px solid #d1d5db;
    display: flex;
    margin-bottom: 20px;
}
.tab-button {
    padding: 10px 20px;
    cursor: pointer;
    border-bottom: 2px solid transparent;
    color: #4b5563;
    font-weight: bold;
    background: none;
    border: none;
    outline: none;
}
.tab-button.active {
    color: #0ea7c2ff;
    border-bottom: 2px solid #018c9eff;
}
.table-container {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    overflow: hidden;
}
.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 20px;
    background-color: #f3f4f6;
    font-weight: bold;
    color: #374151;
}
.table-header a.button {
    text-decoration: none;
    background-color: #0babc0ff;
    color: white;
    padding: 8px 16px;
    border-radius: 5px;
}
.table-header a.button:hover {
    background-color: #2563eb;
}
table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}
thead {
    background-color: #f9fafb;
    color: #374151;
}
th, td {
    padding: 12px 20px;
    border-bottom: 1px solid #e5e7eb;
    text-align: left;
}
tr:hover {
    background-color: #f3f4f6;
}
.hidden {
    display: none;
}
.text-center {
    text-align: center;
    color: #6b7280;
}
a.action-link {
    text-decoration: none;
    margin-right: 5px;
}
a.view { color: #2563eb; }
a.view:hover { text-decoration: underline; }
a.activate { color: #16a34a; }
a.activate:hover { text-decoration: underline; }
a.deactivate { color: #dc2626; }
a.deactivate:hover { text-decoration: underline; }
</style>
</head>
<body>

<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>

<div class="container">
  <!-- Tabs -->
  <div class="tabs">
      <button class="tab-button active" data-tab="active">Active Users</button>
      <button class="tab-button" data-tab="inactive">Inactive Users</button>
  </div>

  <!-- Active Users -->
  <div id="active" class="tab-content">
    <div class="table-container">
      <div class="table-header">
        <span>Active Users</span>
        <a href="add_user.php" class="button">Add User</a>
      </div>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Barangay</th>
            <th>Role</th>
            <th>Created</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($activeUsers as $u): ?>
          <tr>
            <td><?= htmlspecialchars($u['full_name']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= htmlspecialchars($u['barangay']) ?></td>
            <td><?= htmlspecialchars($u['user_type']) ?></td>
            <td><?= htmlspecialchars($u['created_date']) ?></td>
            <td>
              <a href="view_profile.php?id=<?= $u['id'] ?>" class="action-link view">View</a>
              <a href="users.php?action=deactivate&id=<?= $u['id'] ?>" class="action-link deactivate" onclick="return confirm('Deactivate this user?')">Deactivate</a>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php if (empty($activeUsers)): ?>
          <tr><td colspan="6" class="text-center">No active users found</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Inactive Users -->
  <div id="inactive" class="tab-content hidden">
    <div class="table-container">
      <div class="table-header">
        <span>Inactive Users</span>
        <a href="add_user.php" class="button">Add User</a>
      </div>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Barangay</th>
            <th>Role</th>
            <th>Created</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($inactiveUsers as $u): ?>
          <tr>
            <td><?= htmlspecialchars($u['full_name']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= htmlspecialchars($u['barangay']) ?></td>
            <td><?= htmlspecialchars($u['user_type']) ?></td>
            <td><?= htmlspecialchars($u['created_date']) ?></td>
            <td>
              <a href="view_user.php?id=<?= $u['id'] ?>" class="action-link view">View</a>
              <a href="users.php?action=activate&id=<?= $u['id'] ?>" class="action-link activate" onclick="return confirm('Activate this user?')">Activate</a>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php if (empty($inactiveUsers)): ?>
          <tr><td colspan="6" class="text-center">No inactive users found</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
// tab switch
const tabs = document.querySelectorAll(".tab-button");
const contents = document.querySelectorAll(".tab-content");

tabs.forEach(tab => {
  tab.addEventListener("click", () => {
    tabs.forEach(t => t.classList.remove("active"));
    tab.classList.add("active");

    contents.forEach(c => c.classList.add("hidden"));
    document.getElementById(tab.dataset.tab).classList.remove("hidden");
  });
});
</script>

</body>
</html>
