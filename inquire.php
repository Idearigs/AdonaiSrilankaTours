<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['travel-search'])) {
    // Validate form data
    $errors = [];

    // Required fields validation
    if (empty($_POST['full_name'])) {
        $errors[] = 'Full name is required';
    }
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email address is required';
    }
    if (empty($_POST['pax_number']) || $_POST['pax_number'] > 40 || $_POST['pax_number'] < 1) {
        $errors[] = 'Valid Pax Number is required (1-40)';
    }
    if (empty($_POST['checkin_date'])) {
        $errors[] = 'Check-in date is required';
    }
    if (empty($_POST['checkout_date'])) {
        $errors[] = 'Check-out date is required';
    }

    // Date validation
    if (!empty($_POST['checkin_date']) && !empty($_POST['checkout_date'])) {
        try {
            $checkin = new DateTime($_POST['checkin_date']);
            $checkout = new DateTime($_POST['checkout_date']);
            $today = new DateTime('today');

            if ($checkin < $today) {
                $errors[] = 'Check-in date cannot be in the past';
            }

            if ($checkout <= $checkin) {
                $errors[] = 'Check-out date must be after check-in date';
            }
        } catch (Exception $e) {
            $errors[] = 'Invalid date format provided';
        }
    }

    // If no errors, proceed with email
    if (empty($errors)) {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'server326.web-hosting.com';
            $mail->SMTPAuth   = true;
            $mail->Username  = 'info@adonaisrilankatours.com';
            $mail->Password  = '#Nilanka#2024';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            // Recipients
            $mail->setFrom('info@adonaisrilankatours.com', 'Quick Inquiries');
            $mail->addAddress('minukadev404@gmail.com', 'Recipient Name');
            $mail->addReplyTo($_POST['email'], $_POST['full_name']); // Fixed: using email field

            // Modern HTML Email Template
            $emailTemplate = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>New Travel Inquiry</title>
                <style>
                    /* Your existing CSS styles */
                </style>
            </head>
            <body>
                <div class="email-container">
                    <div class="header">
                        <h1>Quick Inquiry Form</h1>
                    </div>

                    <div class="content">
                        <div class="logo">
                            <img src="https://via.placeholder.com/150x50?text=Your+Logo" alt="Company Logo">
                        </div>

                        <p>Hello Team,</p>
                        <p>You have received a new travel inquiry with the following details:</p>

                        <table class="data-table">
                            <tr>
                                <th>Full Name:</th>
                                <td>'.htmlspecialchars($_POST['full_name']).'</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>'.htmlspecialchars($_POST['email']).'</td>
                            </tr>
                            <tr>
                                <th>Budget:</th>
                                <td>'.(!empty($_POST['budget']) ? htmlspecialchars($_POST['budget']) : 'Not specified').'</td>
                            </tr>
                            <tr>
                                <th>Number of People:</th>
                                <td>'.htmlspecialchars($_POST['pax_number']).'</td>
                            </tr>
                            <tr>
                                <th>Trip Dates:</th>
                                <td>'.htmlspecialchars($_POST['checkin_date']).' to '.htmlspecialchars($_POST['checkout_date']).'</td>
                            </tr>
                        </table>

                        <div class="highlight-box">
                            <p><strong>Action Required:</strong> Please respond to this inquiry within 24 hours.</p>
                            <p>You can reply directly to this email or contact the client using the information provided above.</p>
                        </div>

                        <p>Best regards,<br>Your Website Team</p>
                    </div>

                    <div class="footer">
                        <p>Email service provided by <strong>Idearigs</strong> &copy; '.date('Y').'</p>
                    </div>
                </div>
            </body>
            </html>';

            // Plain text version
            $plainText = "QUICK INQUIRY FORM\n\n";
            $plainText .= "Full Name: ".$_POST['full_name']."\n";
            $plainText .= "Email: ".$_POST['email']."\n";
            $plainText .= "Budget: ".(!empty($_POST['budget']) ? $_POST['budget'] : 'Not specified')."\n";
            $plainText .= "Number of People: ".$_POST['pax_number']."\n";
            $plainText .= "Trip Dates: ".$_POST['checkin_date']." to ".$_POST['checkout_date']."\n\n";
            $plainText .= "ACTION REQUIRED: Please respond within 24 hours.\n\n";
            $plainText .= "Email service provided by Idearigs © ".date('Y');

            // Email content configuration
            $mail->isHTML(true);
            $mail->Subject = 'New Travel Inquiry: ' . substr(htmlspecialchars($_POST['full_name']), 0, 30) . ' (' . date('M d, Y') . ')';
            $mail->Body = $emailTemplate;
            $mail->AltBody = $plainText;

            // Send email
            $mail->send();

            // Redirect to thank you page
            header('Location: thank-you.html');
            exit();

        } catch (Exception $e) {
            $errors[] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    // Error handling remains the same
    if (!empty($errors)) {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <!-- Your existing error page HTML -->
        </html>
        <?php
        $output = ob_get_clean();
        echo $output;
        exit();
    }
} else {
    header('Location: index.html');
    exit();
}
?>