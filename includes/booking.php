<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

require_once __DIR__ . '/db.php';

$name    = trim(htmlspecialchars($_POST['name']    ?? ''));
$email   = trim($_POST['email']   ?? '');
$phone   = trim(htmlspecialchars($_POST['phone']   ?? ''));
$service = trim(htmlspecialchars($_POST['service'] ?? ''));
$date    = trim($_POST['date']    ?? '');
$message = trim(htmlspecialchars($_POST['message'] ?? ''));

if (!$name || !$email || !$service) {
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}
if ($date && strtotime($date) < strtotime('today')) {
    echo json_encode(['success' => false, 'message' => 'Please select a future date.']);
    exit;
}

try {
    $stmt = $pdo->prepare('INSERT INTO bookings (name, email, phone, service, date, message) VALUES (?,?,?,?,?,?)');
    $stmt->execute([$name, $email, $phone, $service, $date ?: null, $message]);
} catch (Exception $e) {
    error_log('Booking save error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Could not save your booking. Please try again.']);
    exit;
}

// Email notification
$to      = 'info@lamicogroup.org'; // ← update this
$subject = "New Booking Request — $service";
$body    = "Name: $name\nEmail: $email\nPhone: $phone\nService: $service\nPreferred Date: $date\n\nNotes:\n$message";
$headers = "From: noreply@lamicogroup.org\r\nReply-To: $email\r\nX-Mailer: PHP/" . phpversion();

@mail($to, $subject, $body, $headers);

echo json_encode(['success' => true, 'message' => 'Booking request received! We\'ll confirm your appointment within 24 hours.']);
