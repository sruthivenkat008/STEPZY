<?php
// Complete CRUD Operations for Products via PHP + MySQL
require_once __DIR__ . '/../config/database.php';

$pdo = Database::getConnection();
$method = $_SERVER['REQUEST_METHOD'];
$data = getRequestData();
$action = $_GET['action'] ?? ($data['action'] ?? '');

// CREATE
if ($action === 'create' || ($method === 'POST' && empty($action) && isset($data['name']) && !isset($data['id']))) {
    $name = trim($data['name'] ?? '');
    $categorySlug = trim($data['category'] ?? ($data['category_slug'] ?? 'men'));
    $division = trim($data['division'] ?? ($name . ' • Performance Series'));
    $price = (float)($data['price'] ?? 0);
    $originalPrice = !empty($data['original_price']) ? (float)$data['original_price'] : null;
    $badgeText = trim($data['badge_text'] ?? 'NEW DROP');
    $badgeClass = trim($data['badge_class'] ?? 'badge-purple');
    $imageUrl = trim($data['image_url'] ?? 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=600&q=80');
    $sizes = trim($data['sizes'] ?? 'US 8, US 9, US 10, US 11');
    $description = trim($data['description'] ?? 'Precision engineered Stepzy sports footwear.');

    if (empty($name)) {
        sendResponse(false, 'Validation Error: Product name is required.', [], 422);
    }
    if ($price <= 0) {
        sendResponse(false, 'Validation Error: Price must be greater than $0.00.', [], 422);
    }

    try {
        $stmt = $pdo->prepare("
            INSERT INTO products (
                name, category_slug, division, price, original_price, 
                rating, review_count, badge_text, badge_class, 
                image_url, sizes, is_new, is_sale, stock_quantity, description
            ) VALUES (
                :name, :cat_slug, :division, :price, :orig_price,
                5.0, 10, :badge_text, :badge_class,
                :img_url, :sizes, 1, 0, 50, :description
            )
        ");
        $stmt->execute([
            ':name'         => $name,
            ':cat_slug'     => $categorySlug,
            ':division'     => $division,
            ':price'        => $price,
            ':orig_price'   => $originalPrice,
            ':badge_text'   => $badgeText,
            ':badge_class'  => $badgeClass,
            ':img_url'      => $imageUrl,
            ':sizes'        => $sizes,
            ':description'  => $description
        ]);

        $newId = (int)$pdo->lastInsertId();
        sendResponse(true, "Product '{$name}' created successfully in MySQL (ID: #{$newId}).", [
            'created_id' => $newId,
            'product' => array_merge($data, ['id' => $newId, 'price' => $price])
        ], 201);
    } catch (Exception $e) {
        sendResponse(false, 'MySQL Insert Error: ' . $e->getMessage(), [], 500);
    }
}

// READ
if ($action === 'read' || ($method === 'GET' && isset($_GET['id']))) {
    $id = (int)($_GET['id'] ?? $data['id'] ?? 0);
    if ($id <= 0) {
        sendResponse(false, 'Validation Error: Valid product ID is required.', [], 400);
    }

    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $product = $stmt->fetch();

    if (!$product) {
        sendResponse(false, "Product #{$id} not found in database.", [], 404);
    }

    $product['price'] = (float)$product['price'];
    $product['original_price'] = $product['original_price'] !== null ? (float)$product['original_price'] : null;
    $product['rating'] = (float)$product['rating'];

    sendResponse(true, "Product details loaded.", ['product' => $product]);
}

// UPDATE
if ($action === 'update' || $method === 'PUT' || ($method === 'POST' && isset($data['id']) && $action !== 'delete')) {
    $id = (int)($data['id'] ?? $_GET['id'] ?? 0);
    if ($id <= 0) {
        sendResponse(false, 'Validation Error: Product ID is required for update.', [], 422);
    }

    $name = trim($data['name'] ?? '');
    $price = isset($data['price']) ? (float)$data['price'] : null;
    $division = trim($data['division'] ?? '');
    $categorySlug = trim($data['category'] ?? ($data['category_slug'] ?? ''));

    if ($name === '' && $price === null && $division === '') {
        sendResponse(false, 'Validation Error: No fields provided to update.', [], 422);
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $existing = $stmt->fetch();

        if (!$existing) {
            sendResponse(false, "Cannot update: Product #{$id} does not exist.", [], 404);
        }

        $upName = !empty($name) ? $name : $existing['name'];
        $upPrice = ($price !== null && $price > 0) ? $price : (float)$existing['price'];
        $upDivision = !empty($division) ? $division : $existing['division'];
        $upCategory = !empty($categorySlug) ? $categorySlug : $existing['category_slug'];

        $updateStmt = $pdo->prepare("
            UPDATE products 
            SET name = :name, price = :price, division = :division, category_slug = :cat
            WHERE id = :id
        ");
        $updateStmt->execute([
            ':name'     => $upName,
            ':price'    => $upPrice,
            ':division' => $upDivision,
            ':cat'      => $upCategory,
            ':id'       => $id
        ]);

        sendResponse(true, "Product #{$id} ('{$upName}') updated successfully in MySQL.", [
            'updated_product' => [
                'id' => $id,
                'name' => $upName,
                'price' => $upPrice,
                'division' => $upDivision,
                'category_slug' => $upCategory
            ]
        ]);
    } catch (Exception $e) {
        sendResponse(false, 'MySQL Update Error: ' . $e->getMessage(), [], 500);
    }
}

// DELETE
if ($action === 'delete' || $method === 'DELETE') {
    $id = (int)($data['id'] ?? $_GET['id'] ?? 0);
    if ($id <= 0) {
        sendResponse(false, 'Validation Error: Valid Product ID is required to delete.', [], 422);
    }

    try {
        $checkStmt = $pdo->prepare("SELECT name FROM products WHERE id = :id");
        $checkStmt->execute([':id' => $id]);
        $product = $checkStmt->fetch();

        if (!$product) {
            sendResponse(false, "Product #{$id} not found or already deleted.", [], 404);
        }

        $delStmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
        $delStmt->execute([':id' => $id]);

        sendResponse(true, "Product #{$id} ('{$product['name']}') deleted permanently from MySQL.", [
            'deleted_id' => $id
        ]);
    } catch (Exception $e) {
        sendResponse(false, 'MySQL Delete Error: ' . $e->getMessage(), [], 500);
    }
}

sendResponse(false, 'Invalid CRUD action specified.', [], 400);
?>