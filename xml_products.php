<?php
// PHP XML Parser for Requirement E
require_once __DIR__ . '/../config/config.php';

$xmlFilePath = __DIR__ . '/../data/products_catalog.xml';

if (!file_exists($xmlFilePath)) {
    sendResponse(false, 'XML Catalog file not found', [], 404);
}

try {
    $xml = simplexml_load_file($xmlFilePath, 'SimpleXMLElement', LIBXML_NOCDATA);
    if ($xml === false) {
        sendResponse(false, 'Failed to parse XML catalog file', [], 500);
    }

    $featuredShoes = [];
    foreach ($xml->featuredShoes->shoe as $shoe) {
        $featuredShoes[] = [
            'id'             => (int)$shoe['id'],
            'category'       => (string)$shoe['category'],
            'name'           => (string)$shoe->name,
            'division'       => (string)$shoe->division,
            'price'          => (float)$shoe->price,
            'original_price' => $shoe->originalPrice ? (float)$shoe->originalPrice : null,
            'rating'         => (float)$shoe->rating,
            'review_count'   => (int)$shoe->reviewCount,
            'energy_return'  => (string)$shoe->energyReturn,
            'carbon_plate'   => (string)$shoe->carbonPlate,
            'badge_text'     => (string)$shoe->badge,
            'image_url'      => (string)$shoe->image,
            'sizes'          => (string)$shoe->sizes,
            'description'    => (string)$shoe->description
        ];
    }

    sendResponse(true, 'XML Catalog successfully parsed by PHP SimpleXML engine.', [
        'source'        => 'data/products_catalog.xml',
        'parser'        => 'PHP SimpleXML 8.x',
        'metadata'      => [
            'version'   => (string)$xml->metadata->version,
            'theme'     => (string)$xml->metadata->theme
        ],
        'count'         => count($featuredShoes),
        'xml_products'  => $featuredShoes
    ], 200);

} catch (Exception $e) {
    sendResponse(false, 'XML Parsing Exception: ' . $e->getMessage(), [], 500);
}
?>