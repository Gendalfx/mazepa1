<?php
require 'db.php'; // Підключення до бази даних

// Отримання даних боргу
$stmt = $pdo->query("SELECT amount, last_updated FROM debt WHERE id = 1");
$debt = $stmt->fetch(PDO::FETCH_ASSOC);

// Визначення часу останнього оновлення
$lastUpdated = strtotime($debt['last_updated']);
$currentTime = time();
$timeDiff = $currentTime - $lastUpdated;
$daysPassed = floor($timeDiff / (60 * 60 * 24)); // Кількість днів, що пройшли
$dailyIncrease = $debt['amount'] * 0.05; // 5% від суми боргу
$newDebtAmount = $debt['amount'] + ($dailyIncrease * $daysPassed); // Нова сума боргу

// Оновлення суми боргу, якщо пройшов день
if ($daysPassed > 0) {
    $stmt = $pdo->prepare("UPDATE debt SET amount = ?, last_updated = CURRENT_TIMESTAMP WHERE id = 1");
    $stmt->execute([$newDebtAmount]);
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сайт Боргу</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 50px; }
        h1 { font-size: 2em; }
        .amount { font-size: 1.5em; margin: 20px 0; }
    </style>
</head>
<body>
    <h1>Сума Боргу</h1>
    <div class="amount"><?php echo number_format($newDebtAmount, 2); ?> грн</div>
    <div>Останнє оновлення: <?php echo $daysPassed > 0 ? $daysPassed . ' днів тому' : 'менше години тому'; ?></div>

    <script>
        // Оновлення кожну секунду
        setInterval(() => {
            window.location.reload(); // Перезавантаження сторінки
        }, 1000);
    </script>
</body>
</html>
