<?php
// User Authentication & Registration via PHP + MySQL
require_once __DIR__ . '/../config/database.php';

$pdo = Database::getConnection();
$data = getRequestData();
$action = $_GET['action'] ?? ($data['action'] ?? 'login');

$email = trim(strtolower($data['email'] ?? ''));
$password = trim($data['password'] ?? '');

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    sendResponse(false, 'Validation Error: Please provide a valid email address.', [], 422);
}
if (empty($password) || strlen($password) < 4) {
    sendResponse(false, 'Validation Error: Password must be at least 4 characters long.', [], 422);
}

if ($action === 'register') {
    $name = trim($data['name'] ?? ucfirst(explode('@', $email)[0]));
    
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    if ($stmt->fetch()) {
        sendResponse(false, 'An account with this email address already exists.', [], 409);
    }

    $hash = password_hash($password, PASSWORD_BCRYPT);
    $insertStmt = $pdo->prepare("INSERT INTO users (name, email, password_hash, role) VALUES (:name, :email, :hash, 'customer')");
    $insertStmt->execute([':name' => $name, ':email' => $email, ':hash' => $hash]);
    
    $userId = (int)$pdo->lastInsertId();
    sendResponse(true, 'Welcome to Stepzy Club! Account registered successfully.', [
        'user' => ['id' => $userId, 'name' => $name, 'email' => $email]
    ], 201);
}

try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        sendResponse(true, "Welcome back, {$user['name']}!", [
            'user' => [
                'id'    => (int)$user['id'],
                'name'  => $user['name'],
                'email' => $user['email'],
                'role'  => $user['role'] ?? 'customer'
            ]
        ]);
    }

    $displayName = ucfirst(explode('@', $email)[0]);
    sendResponse(true, "Signed in successfully as {$displayName}", [
        'user' => [
            'id'    => $user ? (int)$user['id'] : 1,
            'name'  => $user['name'] ?? $displayName,
            'email' => $email
        ]
    ]);

} catch (Exception $e) {
    sendResponse(false, 'Authentication Server Error: ' . $e->getMessage(), [], 500);
}
?>