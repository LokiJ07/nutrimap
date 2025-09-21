<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';



function sendOTP($toEmail, $otp) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'danmarkpetalcurin@gmail.com';   // 👉 your Gmail
        $mail->Password   = 'qdal zfxu fsej bqqf';           // 👉 Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('danmarkpetalcurin@gmail.com', 'CNO NutriMap');
        $mail->addAddress($toEmail);

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Your One-Time Password (OTP) for CNO NutriMap";
        $mail->Body    = "
            Hello,<br><br>
            Your One-Time Password (OTP) for CNO NutriMap login is: 
            <strong>" . htmlspecialchars($otp) . "</strong><br><br>
            This OTP is valid for 5 minutes.<br><br>
            Do not share this code with anyone.<br><br>
            Best regards,<br>
            The CNO NutriMap Team
        ";
        $mail->AltBody = "
            Hello,\n\n
            Your One-Time Password (OTP) for CNO NutriMap login is: $otp\n\n
            This OTP is valid for 5 minutes.\n\n
            Do not share this code with anyone.\n\n
            Best regards,\n
            The CNO NutriMap Team
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        // In case of failure, you can log $e->getMessage()
        return false;
    }
}
