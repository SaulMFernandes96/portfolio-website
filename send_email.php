<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];
    $recaptcha_response = $_POST["g-recaptcha-response"];

    // Verify reCAPTCHA
    $secret_key = "6LfJ3OUqAAAAAIrBdirTupt_VTb2b4SCimuBhGsE";
    $verify_url = "https://www.google.com/recaptcha/api/siteverify";
    $response = file_get_contents("$verify_url?secret=$secret_key&response=$recaptcha_response");
    $response_data = json_decode($response);

    if (!$response_data->success) {
        die("reCAPTCHA verification failed. Please try again.");
    }

    // Send email
    $to = "saulmfernandes@outlook.com";
    $subject = "New Contact Form Submission";
    $headers = "From: $email\r\nReply-To: $email";

    if (mail($to, $subject, $message, $headers)) {
        echo "Email sent successfully!";
    } else {
        echo "Email sending failed.";
    }
} else {
    echo "Invalid request.";
}
?>
