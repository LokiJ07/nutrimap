<?php
require "../db/config.php";

// Handle Activate/Deactivate actions
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
<meta charset="UTF-8">
<title>User Management</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>

<div class="p-6">
  <!-- Tabs -->
  <div class="border-b border-gray-300 mb-4">
    <nav class="flex space-x-4">
      <button class="tab-button py-2 px-4 text-blue-600 border-b-2 border-blue-600 font-semibold" data-tab="active">Active Users</button>
      <button class="tab-button py-2 px-4 text-gray-600 hover:text-blue-600" data-tab="inactive">Inactive Users</button>
    </nav>
  </div>

  <!-- Active Users -->
  <div id="active" class="tab-content">
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <table class="w-full text-sm text-left">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-6 py-3">Name</th>
            <th class="px-6 py-3">Email</th>
            <th class="px-6 py-3">Barangay</th>
            <th class="px-6 py-3">Role</th>
            <th class="px-6 py-3">Created</th>
            <th class="px-6 py-3">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($activeUsers as $u): ?>
          <tr class="border-b">
            <td class="px-6 py-3"><?= htmlspecialchars($u['full_name']) ?></td>
            <td class="px-6 py-3"><?= htmlspecialchars($u['email']) ?></td>
            <td class="px-6 py-3"><?= htmlspecialchars($u['barangay']) ?></td>
            <td class="px-6 py-3"><?= htmlspecialchars($u['user_type']) ?></td>
            <td class="px-6 py-3"><?= htmlspecialchars($u['created_date']) ?></td>
            <td class="px-6 py-3">
              <a href="view_profile.php?id=<?= $u['id'] ?>" class="text-blue-600 hover:underline">View</a> | 
              <a href="users.php?action=deactivate&id=<?= $u['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Deactivate this user?')">Deactivate</a>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php if (empty($activeUsers)): ?>
          <tr><td colspan="6" class="px-6 py-3 text-center text-gray-500">No active users found</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Inactive Users -->
  <div id="inactive" class="tab-content hidden">
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <table class="w-full text-sm text-left">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-6 py-3">Name</th>
            <th class="px-6 py-3">Email</th>
            <th class="px-6 py-3">Barangay</th>
            <th class="px-6 py-3">Role</th>
            <th class="px-6 py-3">Created</th>
            <th class="px-6 py-3">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($inactiveUsers as $u): ?>
          <tr class="border-b">
            <td class="px-6 py-3"><?= htmlspecialchars($u['full_name']) ?></td>
            <td class="px-6 py-3"><?= htmlspecialchars($u['email']) ?></td>
            <td class="px-6 py-3"><?= htmlspecialchars($u['barangay']) ?></td>
            <td class="px-6 py-3"><?= htmlspecialchars($u['user_type']) ?></td>
            <td class="px-6 py-3"><?= htmlspecialchars($u['created_date']) ?></td>
            <td class="px-6 py-3">
              <a href="view_user.php?id=<?= $u['id'] ?>" class="text-blue-600 hover:underline">View</a> | 
              <a href="users.php?action=activate&id=<?= $u['id'] ?>" class="text-green-600 hover:underline" onclick="return confirm('Activate this user?')">Activate</a>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php if (empty($inactiveUsers)): ?>
          <tr><td colspan="6" class="px-6 py-3 text-center text-gray-500">No inactive users found</td></tr>
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
    tabs.forEach(t => t.classList.remove("text-blue-600", "border-blue-600"));
    tabs.forEach(t => t.classList.add("text-gray-600"));
    tab.classList.add("text-blue-600", "border-b-2", "border-blue-600");

    contents.forEach(c => c.classList.add("hidden"));
    document.getElementById(tab.dataset.tab).classList.remove("hidden");
  });
});
</script>

</body>
</html>
