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
        $mail->Body    = "Full name: $name<br>
                          Special Note: $special_note<br>
                          Pax Number: $pax_number<br>
                          Checkin Date: $checkin_date<br>
                          Checkout Date: $checkout_date";

        $mail->send();
        header('Location: index.html?status=success');
    } catch (Exception $e) {
        header('Location: index.html?status=error');
    }
    exit();
}
?>
