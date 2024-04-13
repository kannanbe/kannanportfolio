<?php
// Check if all required form fields are present and valid
if(empty($_POST['name']) || empty($_POST['subject']) || empty($_POST['message']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400); // Bad Request
    echo "Please fill out all required fields and provide a valid email address.";
    exit();
}

// Sanitize form inputs
$name = strip_tags(htmlspecialchars($_POST['name']));
$email = strip_tags(htmlspecialchars($_POST['email']));
$m_subject = strip_tags(htmlspecialchars($_POST['subject']));
$message = strip_tags(htmlspecialchars($_POST['message']));

// Set email recipient and subject
$to = "narendrankannan119@gmail.com"; // Change this email to your own
$subject = "$m_subject: $name";

// Compose email body
$body = "You have received a new message from your website contact form.\n\n";
$body .= "Here are the details:\n\n";
$body .= "Name: $name\n";
$body .= "Email: $email\n";
$body .= "Subject: $m_subject\n";
$body .= "Message: $message\n";

// Set additional email headers
$header = "From: $email\r\n";
$header .= "Reply-To: $email\r\n";

// Attempt to send email
if(mail($to, $subject, $body, $header)) {
    http_response_code(200); // Success
    echo "Your message has been sent successfully!";
} else {
    http_response_code(500); // Internal Server Error
    echo "Sorry, there was a problem sending your message. Please try again later.";

    // Log error
    error_log("Failed to send email. Details: Name: $name, Email: $email, Subject: $m_subject, Message: $message", 0);
}
?>
