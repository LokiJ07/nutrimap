<?php
session_start();
require 'db/config.php';

// Handle form submission
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $username = trim($_POST['username']);
    $phone_number = trim($_POST['phone_number']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $barangay = isset($_POST['barangay']) ? $_POST['barangay'] : null;
    $user_type = $_POST['user_type']; 
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // If user_type = CNO, force barangay = 'CNO'
    if ($user_type === 'CNO') {
        $barangay = 'CNO';
    }

    if ($password !== $confirm_password) {
        $message = "⚠️ Passwords do not match!";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users 
            (first_name, last_name, username, email, phone_number, address, barangay, user_type, password_hash) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        try {
            $stmt->execute([$first_name, $last_name, $username, $email, $phone_number, $address, $barangay, $user_type, $hash]);
            $message = "✅ Account created successfully!";
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) { // duplicate entry
                $message = "⚠️ Username or Email already exists!";
            } else {
                $message = "❌ Error: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Account - CNO NutriMap</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }
        .topbar {
            background: white;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
        }
        .topbar h2 {
            margin: 0;
            font-size: 18px;
            color: #0d9488;
        }
        .topbar input {
            padding: 5px 10px;
            width: 250px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 40px;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 420px;
        }
        .card h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        input, select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 100%;
        }
        .row {
            display: flex;
            gap: 10px;
        }
        button {
            background: #0d9488;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: #0b7a70;
        }
        p.message {
            text-align: center;
            color: red;
        }
    </style>
</head>
<body>

    <!-- Top Bar -->
    <div class="topbar">
        <div style="display:flex; align-items:center; gap:10px;">
            <span style="font-size:22px; cursor:pointer;">☰</span>
            <h2>CNO NutriMap</h2>
        </div>
        <input type="text" placeholder="Search...">
        <div style="font-size:20px; cursor:pointer;">🔔</div>
    </div>

    <!-- Register Card -->
    <div class="container">
        <div class="card">
            <h2>Create Account</h2>

            <?php if ($message): ?>
                <p class="message"><?= $message ?></p>
            <?php endif; ?>

            <form method="POST">
                <div class="row">
                    <input type="text" name="first_name" placeholder="First Name" required>
                    <input type="text" name="last_name" placeholder="Last Name" required>
                </div>

                <div class="row">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="text" name="phone_number" placeholder="Phone No." required>
                </div>

                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="address" placeholder="Address" required>

                <div class="row">
                    <select name="barangay" id="barangay" required>
                        <option value="">Select Barangay</option>
                        <option value="Amoros">Amoros</option>
                        <option value="Bolisong">Bolisong</option>
                        <option value="Cogon">Cogon</option>
                        <option value="Himaya">Himaya</option>
                        <option value="Hinigdaan">Hinigdaan</option>
                        <option value="Kalabaylabay">Kalabaylabay</option>
                        <option value="Molugan">Molugan</option>
                        <option value="Bolobolo">Bolobolo</option>
                        <option value="Poblacion">Poblacion</option>
                        <option value="Kibonbon">Kibonbon</option>
                        <option value="Sambulawan">Sambulawan</option>
                        <option value="Calongonan">Calongonan</option>
                        <option value="Sinaloc">Sinaloc</option>
                        <option value="Taytay">Taytay</option>
                        <option value="Ulaliman">Ulaliman</option>
                    </select>

                    <select name="user_type" id="user_type" required onchange="toggleBarangay()">
                        <option value="">Select User Type</option>
                        <option value="BNS">BNS</option>
                        <option value="CNO">CNO</option>
                    </select>
                </div>

                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>

                <button type="submit">Register</button>
            </form>
        </div>
    </div>

    <script>
        function toggleBarangay() {
            const userType = document.getElementById("user_type").value;
            const barangaySelect = document.getElementById("barangay");

            if (userType === "CNO") {
                barangaySelect.value = "CNO";
                barangaySelect.disabled = true;
            } else {
                barangaySelect.disabled = false;
            }
        }
    </script>

</body>
</html>
