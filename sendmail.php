<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mail = new PHPMailer(true);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Get and sanitize form data
        $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
        $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
        $mobile = isset($_POST['mobile']) ? htmlspecialchars(trim($_POST['mobile'])) : '';
        $message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo '<script>
                    alert("Invalid email format!");
                    window.history.back();
                  </script>';
            exit;
        }

        // SMTP Configuration
        $mail->isSMTP();
        $mail->SMTPAuth   = true;
        $mail->Host       = 'smtp.gmail.com';
        $mail->Username   = 'maddurinaresh3@gmail.com';  // Your SMTP Email
        $mail->Password   = 'dmcr peuz cmbq dnsy';       // Your App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Recipient (Send to yourself)
        $mail->setFrom('maddurinaresh3@gmail.com', 'Website Contact Form');
        $mail->addAddress('maddurinaresh3@gmail.com', 'Naresh'); // Your email
        $mail->addReplyTo($email, $name); // Allow replies to the user's email

        // Build Email Content
        $emailBody = "<h2>New Contact Form Submission</h2>
                      <p><strong>Name:</strong> $name</p>
                      <p><strong>Email:</strong> $email</p>";
        
        if (!empty($mobile)) {
            $emailBody .= "<p><strong>Mobile:</strong> $mobile</p>";
        }

        if (!empty($message)) {
            $emailBody .= "<p><strong>Message:</strong> $message</p>";
        }

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = "New Contact Form Submission";
        $mail->Body    = $emailBody;

        // Send Email
        if ($mail->send()) {
            echo '<script>
                    alert("Your message has been sent successfully!");
                    window.location.href = "index.html";
                  </script>';
        } else {
            echo '<script>
                    alert("Something went wrong :(");
                    window.history.back();
                  </script>';
        }

    } catch (Exception $e) {
        echo '<script>
                alert("Message could not be sent. Error: ' . addslashes($mail->ErrorInfo) . '");
                window.history.back();
              </script>';
    }
}
?>
