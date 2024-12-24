<?php
require 'vendor/autoload.php'; // Load PHPMailer via Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json'); // Set content type for JSON response

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $budget = htmlspecialchars($_POST['Budget']);
    $contactNumber = htmlspecialchars($_POST['contact-number']);
    $checkinDate = htmlspecialchars($_POST['checkin-date']);
    $checkoutDate = htmlspecialchars($_POST['checkout-date']);
    $specialNotes = htmlspecialchars($_POST['special-notes']);
    $packageName = htmlspecialchars($_POST['package-name']); // Capture the package name

    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'server326.web-hosting.com'; // Replace with your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'info@adonaisrilankatours.com'; // SMTP username
        $mail->Password = '#Nilanka#2024'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Sender and recipient settings
        $mail->setFrom('info@adonaisrilankatours.com', 'Adonai Sri Lanka Tours'); // Sender email and name
        $mail->addAddress('info@adonaisrilankatours.com', 'Booking Team'); // Replace with the recipient's email

        // Professional Email Template
        $mail->isHTML(true);
        $mail->Subject = 'New Booking Inquiry from Adonaisrilankatours.com';
        $mail->Body = "
            <div style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f8f9fa;' >
                <table style='width: 100%; border-collapse: collapse;' >
                    <thead style='background-color: #1c2331; color: white;' >
                        <tr>
                            <th style='padding: 20px; font-size: 24px; text-align: center;'>New Contact from Adonaisrilankatours.com</th>
                        </tr>
                    </thead>
                    <tbody style='background-color: #ffffff;' >
                        <tr>
                            <td style='padding: 20px;' >
                                <h3 style='color: #343a40;'>Booking Inquiry Details</h3>
                                <p><strong>Name:</strong> $name</p>
                                <p><strong>Email:</strong> $email</p>
                                <p><strong>Budget:</strong> $budget</p>
                                <p><strong>Contact Number:</strong> $contactNumber</p>
                                <p><strong>Check-in Date:</strong> $checkinDate</p>
                                <p><strong>Check-out Date:</strong> $checkoutDate</p>
                                <p><strong>Special Notes:</strong> $specialNotes</p>
                                <p><strong>Package Name:</strong> $packageName</p> <!-- Display the package name -->
                            </td>
                        </tr>
                    </tbody>
                    <tfoot style='background-color: #1c2331; color: white;' >
                        <tr>
                            <td style='padding: 20px; text-align: center;' >
                                <p>Email services by <strong>IdeaRigs</strong></p>
                                <p>&copy; 2024 IdeaRigs. All rights reserved.</p>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        ";

        // Send email
        $mail->send();

        // Respond with success message
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        // Respond with error message
        echo json_encode(['success' => false, 'message' => 'Failed to send email. Please try again later.']);
    }
} else {
    // Invalid request method
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
