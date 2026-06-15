<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

require_once __DIR__ . '/db.php';

// Sanitize inputs
$name    = trim(htmlspecialchars($_POST['name']    ?? ''));
$email   = trim($_POST['email']   ?? '');
$phone   = trim(htmlspecialchars($_POST['phone']   ?? ''));
$subject = trim(htmlspecialchars($_POST['subject'] ?? ''));
$message = trim(htmlspecialchars($_POST['message'] ?? ''));

// Validate
if (!$name || !$email || !$message) {
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

// Save to DB
try {
    $stmt = $pdo->prepare('INSERT INTO contacts (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$name, $email, $phone, $subject, $message]);
} catch (Exception $e) {
    error_log('Contact save error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Could not save your message. Please try again.']);
    exit;
}

// Send email notification
$to      = 'info@lamicogroup.org'; // ← update this
$subject_line = 'New Contact Form Message: ' . ($subject ?: 'General Enquiry');
$body    = "Name: $name\nEmail: $email\nPhone: $phone\n\nSubject: $subject\n\nMessage:\n$message";
$headers = "From: noreply@lamicogroup.org\r\nReply-To: $email\r\nX-Mailer: PHP/" . phpversion();

@mail($to, $subject_line, $body, $headers);

echo json_encode(['success' => true, 'message' => 'Thank you! Your message has been received. We\'ll be in touch shortly.']);
