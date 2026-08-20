<?php


session_start();

require_once "vendor/autoload.php";
require_once "includes/db.php";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Basic validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        die("Please fill all fields.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Please enter a valid email address.");
    }


    // =========================
    // 1. SAVE MESSAGE IN DATABASE
    // =========================

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO messages (name, email, subject, message)
         VALUES (?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ssss",
        $name,
        $email,
        $subject,
        $message
    );

    if (!mysqli_stmt_execute($stmt)) {

        die("Message could not be saved.");

    }

    mysqli_stmt_close($stmt);


    // =========================
    // 2. SEND EMAIL USING PHPMailer
    // =========================

    $mail = new PHPMailer(true);

    try {

        // SMTP Settings
        $mail->isSMTP();

        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        // YOUR GMAIL
        $mail->Username = $_ENV['GMAIL_USER'];

        // YOUR GMAIL APP PASSWORD
        $mail->Password = $_ENV['GMAIL_APP_PASSWORD'];

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;


        // Sender
        $mail->setFrom(
            $_ENV['GMAIL_USER'],
            'Developer Portfolio'
        );

        $mail->addAddress(
            $_ENV['GMAIL_USER'],
            'Muhammad Farhan'
        );


        // Email content
        $mail->isHTML(true);

        $mail->Subject = "New Portfolio Message: " . $subject;

        $mail->Body = "
            <h2>New Message From Your Portfolio</h2>

            <p><strong>Name:</strong> {$name}</p>

            <p><strong>Email:</strong> {$email}</p>

            <p><strong>Subject:</strong> {$subject}</p>

            <p><strong>Message:</strong></p>

            <p>{$message}</p>
        ";

        $mail->AltBody =
            "New Portfolio Message\n\n" .
            "Name: $name\n" .
            "Email: $email\n" .
            "Subject: $subject\n" .
            "Message: $message";


       if ($mail->send()) {

    $_SESSION['success_message'] = "Message sent successfully! Thank you for contacting me. I will get back to you soon.";

    header("Location: index.php#contact");
    exit();

}

    } catch (Exception $e) {

    echo "Message saved, but email could not be sent.<br>";
    echo "Mailer Error: " . $mail->ErrorInfo;

}
}
?>