<?php
header('Content-Type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Composer autoload
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

// Get form data
$name    = $_POST['name'] ?? '';
$email   = $_POST['email'] ?? '';
$phone   = $_POST['phone'] ?? '';
$message = $_POST['message'] ?? '';

if (empty($name) || empty($email) || empty($phone) || empty($message)) {
    echo json_encode([
        'success' => false,
        'message' => 'Please fill in all the required fields.'
    ]);
    exit;
}

// Setup PHPMailer
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'server326.web-hosting.com'; // Replace with your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'info@adonaisrilankatours.com'; // Replace with your email address
    $mail->Password = '#Nilanka#2024'; // Replace with your email password
    $mail->SMTPSecure = 'tls'; // Use 'ssl' if your server requires it
    $mail->Port = 587; // Common port for TLS, check your server's settings


    // Recipients
    $mail->setFrom('info@adonaisrilankatours.com', 'Adonai Sri Lanka Tours'); // Replace with your email address and name
    $mail->addAddress('adonaitours21@gmail.com'); // Recipient email address

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'New Contact Form Submission';
    $mail->Body = '
        <!DOCTYPE html>
        <html>
        <head>
        <meta charset="UTF-8">
        <style>
            body {
            font-family: "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            color: #333;
            }
            .email-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            }
            .email-header {
            background-color: #0059ff;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            }
            .email-header h1 {
            margin: 0;
            font-size: 22px;
            }
            .email-body {
            padding: 30px;
            }
            .email-body h2 {
            margin-top: 0;
            color: #0059ff;
            }
            .details-table {
            width: 100%;
            border-collapse: collapse;
            }
            .details-table td {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
            }
            .email-footer {
            background-color: #f1f1f1;
            padding: 15px;
            text-align: center;
            font-size: 13px;
            color: #777;
            }
            .email-footer a {
            color: #0059ff;
            text-decoration: none;
            }
        </style>
        </head>
        <body>
        <div class="email-container">
            <div class="email-header">
            <h1>New Contact Form Submission</h1>
            </div>
            <div class="email-body">
            <h2>Submitted Details:</h2>
            <table class="details-table">
                <tr>
                <td><strong>Name:</strong></td>
                <td>' . htmlspecialchars($name) . '</td>
                </tr>
                <tr>
                <td><strong>Email:</strong></td>
                <td>' . htmlspecialchars($email) . '</td>
                </tr>
                <tr>
                <td><strong>Phone:</strong></td>
                <td>' . htmlspecialchars($phone) . '</td>
                </tr>
                <tr>
                <td><strong>Message:</strong></td>
                <td>' . nl2br(htmlspecialchars($message)) . '</td>
                </tr>
            </table>
            </div>
            <div class="email-footer">
            Email service powered by <a href="https://idearigs.com" target="_blank">Idearigs</a>
            </div>
        </div>
        </body>
        </html>';


    $mail->send();

    echo json_encode([
        'success' => true,
        'message' => 'Your message has been sent successfully!'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"
    ]);
}
?>
