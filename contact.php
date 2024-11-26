<?php
require 'vendor/autoload.php'; // Path to Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

header('Content-Type: application/json');

$response = ["success" => false, "message" => ""]; // Initialize the response array

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $message = htmlspecialchars($_POST["message"]);

    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'adonaisrilankatours.com'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'info@adonaisrilankatours.com'; // Replace with your email address
        $mail->Password = '#Nilanka#2024'; // Replace with your email password
        $mail->SMTPSecure = 'tls'; // Use 'ssl' if your server requires it
        $mail->Port = 587; // Common port for TLS, check your server's settings

        // Recipient
        $mail->setFrom('info@adonaisrilankatours.com', 'Adonai Sri Lanka Tours'); // Replace with your email address and name
        $mail->addAddress('info@adonaisrilankatours.com'); // Recipient email address

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Submission';
        
        // Enhanced HTML email body
        $mail->Body    = "
        <html>
        <body style='font-family: Arial, sans-serif;'>
            <h2 style='color: #333;'>New Contact Form Submission</h2>
            <table style='width: 100%; border-collapse: collapse;'>
                <tr style='background-color: #f2f2f2;'>
                    <th style='padding: 10px; text-align: left;'>Field</th>
                    <th style='padding: 10px; text-align: left;'>Details</th>
                </tr>
                <tr>
                    <td style='padding: 10px; border: 1px solid #ddd;'>Name</td>
                    <td style='padding: 10px; border: 1px solid #ddd;'>$name</td>
                </tr>
                <tr>
                    <td style='padding: 10px; border: 1px solid #ddd;'>Email</td>
                    <td style='padding: 10px; border: 1px solid #ddd;'>$email</td>
                </tr>
                <tr>
                    <td style='padding: 10px; border: 1px solid #ddd;'>Phone</td>
                    <td style='padding: 10px; border: 1px solid #ddd;'>$phone</td>
                </tr>
                <tr>
                    <td style='padding: 10px; border: 1px solid #ddd;'>Message</td>
                    <td style='padding: 10px; border: 1px solid #ddd;'>$message</td>
                </tr>
            </table>
        </body>
        </html>
        ";

        $mail->AltBody = "Name: $name\nEmail: $email\nPhone: $phone\nMessage: $message";

        $mail->send();
        
        // Set success response
        $response["success"] = true;
        $response["message"] = "Message sent successfully to info@adonaisrilankatours.com!";
    } catch (Exception $e) {
        $response["message"] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    // Send thank you email to the customer
    try {
        $thankYouMail = new PHPMailer(true);

        // SMTP settings
        $thankYouMail->isSMTP();
        $thankYouMail->Host = 'adonaisrilankatours.com'; // Replace with your SMTP server
        $thankYouMail->SMTPAuth = true;
        $thankYouMail->Username = 'info@adonaisrilankatours.com'; // Replace with your email address
        $thankYouMail->Password = '#Nilanka#2024'; // Replace with your email password
        $thankYouMail->SMTPSecure = 'tls'; // Use 'ssl' if your server requires it
        $thankYouMail->Port = 587; // Common port for TLS, check your server's settings

        // Recipient
        $thankYouMail->setFrom('info@adonaisrilankatours.com', 'Adonai Sri Lanka Tours'); // Replace with your email address and name
        $thankYouMail->addAddress($email); // Customer's email address

        // Content
        $thankYouMail->isHTML(true);
        $thankYouMail->Subject = 'Thank You for Contacting Us';
        $thankYouMail->Body    = "
        <html>
        <body style='font-family: Arial, sans-serif;'>
            <h2 style='color: #333;'>Thank You for Contacting Us</h2>
            <p>Dear $name,</p>
            <p>Thank you for reaching out to us. We have received your message and will get back to you soon.</p>
            <p>Best regards,<br>Adonai Sri Lanka Tours</p>
        </body>
        </html>
        ";
        $thankYouMail->AltBody = "Dear $name,\n\nThank you for contacting us. We will get back to you soon.\n\nBest regards,\nAdonai Sri Lanka Tours";

        $thankYouMail->send();
        
        // Add thank you email status to response
        $response["message"] .= " Thank you email sent successfully to the customer!";
    } catch (Exception $e) {
        $response["message"] .= " Thank you email could not be sent. Mailer Error: {$e->ErrorInfo}";
    }

    // Return JSON response
    echo json_encode($response);
} else {
    $response["message"] = "Invalid request method.";
    echo json_encode($response);
}
?>
