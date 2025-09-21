<?php
session_start();
header('Content-Type: application/json'); // Return JSON response

require 'db/config.php';
require 'otp/mailer.php';

$response = [
    'success' => false,
    'message' => '',
    'redirect' => ''
];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (!empty($email) && !empty($password)) {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
            $stmt->execute([$email, $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password_hash'])) {
                // ✅ Use cryptographically secure OTP
                $otp = random_int(100000, 999999);
                $expires = date("Y-m-d H:i:s", strtotime("+5 minutes"));

                $stmt = $pdo->prepare("INSERT INTO otp_codes (user_id, otp_code, expires_at) VALUES (?, ?, ?)");
                $stmt->execute([$user['id'], $otp, $expires]);

                // Store pending session info
                $_SESSION['pending_user_id'] = $user['id'];
                $_SESSION['pending_user_type'] = $user['user_type'];
                $_SESSION['pending_first_name'] = $user['first_name'];

                if (sendOTP($user['email'], $otp)) {
                    $response['success'] = true;
                    $response['message'] = 'OTP sent successfully!';
                    $response['redirect'] = 'otp/verify_otp.php';
                    http_response_code(200);
                } else {
                    $response['message'] = 'Failed to send OTP email. Please try again.';
                    http_response_code(500);
                }
            } else {
                $response['message'] = 'Invalid email/username or password!';
                http_response_code(401);
            }
        } else {
            $response['message'] = 'All fields are required!';
            http_response_code(400);
        }
    } else {
        $response['message'] = 'Invalid request method!';
        http_response_code(405);
    }
} catch (Exception $e) {
    $response['message'] = 'Server error: ' . $e->getMessage();
    http_response_code(500);
}

echo json_encode($response);
