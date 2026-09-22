<?php
// Retrieve Products from MySQL with Search & Category Filtering
require_once __DIR__ . '/../config/database.php';

try {
    $pdo = Database::getConnection();

    $category = trim($_GET['category'] ?? '');
    $search = trim($_GET['q'] ?? ($_GET['search'] ?? ''));
    $sortBy = trim($_GET['sort'] ?? '');

    $sql = "SELECT * FROM products WHERE 1=1";
    $params = [];

    if (!empty($category)) {
        if ($category === 'new') {
            $sql .= " AND is_new = 1";
        } elseif ($category === 'sale') {
            $sql .= " AND is_sale = 1";
        } elseif (in_array($category, ['men', 'women', 'kids', 'sports'])) {
            $sql .= " AND category_slug = :category";
            $params[':category'] = $category;
        }
    }

    if (!empty($search)) {
        $sql .= " AND (name LIKE :s_name OR division LIKE :s_div OR description LIKE :s_desc)";
        $term = "%{$search}%";
        $params[':s_name'] = $term;
        $params[':s_div'] = $term;
        $params[':s_desc'] = $term;
    }

    if ($sortBy === 'price_asc') {
        $sql .= " ORDER BY price ASC";
    } elseif ($sortBy === 'price_desc') {
        $sql .= " ORDER BY price DESC";
    } elseif ($sortBy === 'rating') {
        $sql .= " ORDER BY rating DESC";
    } else {
        $sql .= " ORDER BY id ASC";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll();

    foreach ($products as &$p) {
        $p['price'] = (float)$p['price'];
        $p['original_price'] = $p['original_price'] !== null ? (float)$p['original_price'] : null;
        $p['rating'] = (float)$p['rating'];
        $p['is_new'] = (bool)$p['is_new'];
        $p['is_sale'] = (bool)$p['is_sale'];
    }

    sendResponse(true, 'Products retrieved successfully from MySQL.', [
        'count' => count($products),
        'products' => $products
    ]);

} catch (Exception $e) {
    sendResponse(false, 'Failed to retrieve products: ' . $e->getMessage(), [], 500);
}
?>