<?php
// db.php
$databaseFile = __DIR__ . '/database.db'; // Шлях до вашого файлу бази даних

try {
    $pdo = new PDO("sqlite:$databaseFile");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Помилка з'єднання: " . $e->getMessage();
}

// Створення таблиці, якщо її немає
$pdo->exec("CREATE TABLE IF NOT EXISTS debt (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    amount REAL NOT NULL,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Додайте початкове значення боргу, якщо таблиця порожня
$result = $pdo->query("SELECT COUNT(*) FROM debt")->fetchColumn();
if ($result == 0) {
    $pdo->exec("INSERT INTO debt (amount) VALUES (1800.00)");
}
?>
