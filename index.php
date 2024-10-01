<?php
// Файл для зберігання боргу
$file = 'debt.txt';

// Читання значень з файлу
if (file_exists($file)) {
    $data = file($file, FILE_IGNORE_NEW_LINES);
    $amount = (float)$data[0]; // Сума боргу
    $last_updated = $data[1]; // Дата останнього оновлення
} else {
    // Якщо файл не існує, створити його з початковими значеннями
    $amount = 1800.00; // Початкова сума боргу
    $last_updated = date('Y-m-d H:i:s');
    file_put_contents($file, "$amount\n$last_updated");
}

// Обчислення нової суми боргу
$time_diff = time() - strtotime($last_updated);
$days = floor($time_diff / (60 * 60 * 24));

if ($days > 0) {
    $amount += $amount * 0.05 * $days; // Збільшення на 5% за кожен день
    $last_updated = date('Y-m-d H:i:s');
    
    // Оновлення значень у файлі
    file_put_contents($file, "$amount\n$last_updated");
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сума Боргу</title>
</head>
<body>
    <h1>Сума Боргу</h1>
    <p><?php echo number_format($amount, 2, '.', ' ') . ' грн'; ?></p>
    <p>Останнє оновлення: <?php echo $last_updated; ?></p>
    <script>
        // Оновлення даних кожні 5 секунд
        setInterval(() => {
            location.reload();
        }, 5000);
    </script>
</body>
</html>
