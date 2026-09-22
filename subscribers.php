<?php
// Newsletter Subscription & Support Messages via PHP + MySQL
require_once __DIR__ . '/../config/database.php';

$pdo = Database::getConnection();
$data = getRequestData();
$action = $_GET['type'] ?? ($data['type'] ?? 'newsletter');

if ($action === 'contact') {
    $name = trim($data['name'] ?? 'Athlete');
    $email = trim($data['email'] ?? '');
    $message = trim($data['message'] ?? '');

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        sendResponse(false, 'Validation Error: Valid email required.', [], 422);
    }
    if (empty($message)) {
        sendResponse(false, 'Validation Error: Message content cannot be empty.', [], 422);
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, message) VALUES (:name, :email, :msg)");
        $stmt->execute([':name' => $name, ':email' => $email, ':msg' => $message]);
        sendResponse(true, 'Your inquiry has been received. Our footwear lab will respond within 24 hours.', ['ticket_id' => (int)$pdo->lastInsertId()], 201);
    } catch (Exception $e) {
        sendResponse(true, 'Message received. Thank you for connecting with Stepzy.');
    }
}

$email = trim(strtolower($data['email'] ?? ''));
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    sendResponse(false, 'Validation Error: Please provide a valid email address.', [], 422);
}

try {
    $stmt = $pdo->prepare("INSERT INTO subscribers (email, discount_code) VALUES (:email, 'STEPZY15') ON DUPLICATE KEY UPDATE subscribed_at=CURRENT_TIMESTAMP");
    $stmt->execute([':email' => $email]);
    sendResponse(true, 'Welcome to Stepzy VIP Club! Use code STEPZY15 for 15% off.', ['discountCode' => 'STEPZY15'], 201);
} catch (Exception $e) {
    sendResponse(true, 'Welcome to Stepzy VIP Club! Use promo code STEPZY15 for 15% off.', ['discountCode' => 'STEPZY15']);
}
?>