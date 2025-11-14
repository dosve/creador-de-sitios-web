<?php

declare(strict_types=1);

$dbPath = __DIR__ . '/../database/database.sqlite';

if (!file_exists($dbPath)) {
    fwrite(STDERR, "No se encontró la base SQLite en {$dbPath}\n");
    exit(1);
}

$pdo = new PDO('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$site = $pdo->query('SELECT * FROM websites LIMIT 1')->fetch();

if (!$site) {
    fwrite(STDERR, "No hay registros en la tabla websites.\n");
    exit(1);
}

$pagesStmt = $pdo->prepare(
    'SELECT id, title, slug, is_published, is_home, enable_store,
            LENGTH(html_content) AS html_len
     FROM pages
     WHERE website_id = ?
     ORDER BY sort_order'
);
$pagesStmt->execute([$site['id']]);
$pages = $pagesStmt->fetchAll();

$menuStmt = $pdo->prepare(
    'SELECT menu_items.*
     FROM menu_items
     JOIN menus ON menus.id = menu_items.menu_id
     WHERE menus.website_id = ?
     ORDER BY menu_items.parent_id, menu_items."order"'
);
$menuStmt->execute([$site['id']]);
$menuItems = $menuStmt->fetchAll();

$templateStmt = $pdo->prepare(
    'SELECT configuration, customization, settings
     FROM template_configurations
     WHERE website_id = ?'
);
$templateStmt->execute([$site['id']]);
$template = $templateStmt->fetch();

echo "SITE:\n";
print_r($site);

echo "\nPAGES:\n";
foreach ($pages as $row) {
    print_r($row);
}

echo "\nMENU ITEMS:\n";
if ($menuItems) {
    foreach ($menuItems as $row) {
        print_r($row);
    }
} else {
    echo "Sin menús configurados\n";
}

echo "\nTEMPLATE CONFIG (resumen):\n";
if ($template) {
    foreach ($template as $key => $value) {
        $snippet = is_string($value) ? substr($value, 0, 400) : $value;
        echo $key . ': ' . (is_string($snippet) ? $snippet : json_encode($snippet)) . "\n";
    }
} else {
    echo "Sin registros en template_configurations para este sitio\n";
}


