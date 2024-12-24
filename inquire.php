<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['s']);
    $special_note = htmlspecialchars($_POST['special_note']);
    $pax_number = htmlspecialchars($_POST['pax_number']);
    $checkin_date = htmlspecialchars($_POST['checkin_date']);
    $checkout_date = htmlspecialchars($_POST['checkout_date']);
    
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'adonaisrilankatours.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'info@adonaisrilankatours.com';
        $mail->Password = '#Nilanka#2024';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('info@adonaisrilankatours.com', 'Adonai Sri Lanka Tours');
        $mail->addAddress('info@adonaisrilankatours.com');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Travel Inquiry';

        // Enhanced HTML email body
        $mail->Body = "
        <html>
        <body style='font-family: Arial, sans-serif; background-color: #f9f9f9; color: #333; padding: 20px;'>
            <div style='max-width: 600px; margin: auto; background: #ffffff; padding: 20px; border: 1px solid #ddd; border-radius: 5px;'>
                <h2 style='text-align: center; color: #0056b3;'>New Travel Inquiry</h2>
                <table style='width: 100%; border-collapse: collapse; margin-top: 20px;'>
                    <tr style='background-color: #f2f2f2;'>
                        <th style='padding: 10px; text-align: left; border: 1px solid #ddd;'>Field</th>
                        <th style='padding: 10px; text-align: left; border: 1px solid #ddd;'>Details</th>
                    </tr>
                    <tr>
                        <td style='padding: 10px; border: 1px solid #ddd;'>Full Name</td>
                        <td style='padding: 10px; border: 1px solid #ddd;'>$name</td>
                    </tr>
                    <tr>
                        <td style='padding: 10px; border: 1px solid #ddd;'>Budget</td>
                        <td style='padding: 10px; border: 1px solid #ddd;'>$special_note</td>
                    </tr>
                    <tr>
                        <td style='padding: 10px; border: 1px solid #ddd;'>Pax Number</td>
                        <td style='padding: 10px; border: 1px solid #ddd;'>$pax_number</td>
                    </tr>
                    <tr>
                        <td style='padding: 10px; border: 1px solid #ddd;'>Check-in Date</td>
                        <td style='padding: 10px; border: 1px solid #ddd;'>$checkin_date</td>
                    </tr>
                    <tr>
                        <td style='padding: 10px; border: 1px solid #ddd;'>Check-out Date</td>
                        <td style='padding: 10px; border: 1px solid #ddd;'>$checkout_date</td>
                    </tr>
                </table>
                <p style='text-align: center; margin-top: 20px;'>Thank you for using Adonai Sri Lanka Tours!</p>
            </div>
        </body>
        </html>
        ";

        $mail->AltBody = "Full Name: $name\nSpecial Note: $special_note\nPax Number: $pax_number\nCheck-in Date: $checkin_date\nCheck-out Date: $checkout_date";

        $mail->send();
        header('Location: index.html?status=success');
    } catch (Exception $e) {
        header('Location: index.html?status=error');
    }
    exit();
}
?>
