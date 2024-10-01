<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сайт боргу</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
        }
        h1 {
            color: #333;
        }
        #debt-amount {
            font-size: 2em;
            color: #f00;
        }
    </style>
</head>
<body>
    <h1>Сума боргу</h1>
    <div id="debt-amount">$<span id="debt">1000</span></div>
    <div id="report">Звіт: <span id="report-time"></span></div>

    <script>
        const debtElement = document.getElementById("debt");
        const reportTimeElement = document.getElementById("report-time");

        // Початкове значення боргу
        let debt = parseFloat(localStorage.getItem("debt")) || 1000;
        // Час останнього оновлення
        let lastUpdate = parseInt(localStorage.getItem("lastUpdate")) || Date.now();

        // Функція для оновлення боргу
        function updateDebt() {
            const now = Date.now();
            const elapsedHours = (now - lastUpdate) / (1000 * 60 * 60); // Час в годинах

            if (elapsedHours >= 24) {
                const periods = Math.floor(elapsedHours / 24);
                debt *= Math.pow(1.05, periods); // Збільшення боргу на 5% кожні 24 години
                lastUpdate += periods * 24 * 60 * 60 * 1000; // Оновлення часу останнього оновлення
                localStorage.setItem("debt", debt);
                localStorage.setItem("lastUpdate", lastUpdate);
            }

            debtElement.innerText = debt.toFixed(2);
            reportTimeElement.innerText = new Date(lastUpdate).toLocaleString();
        }

        // Оновлюємо борг при завантаженні сторінки
        updateDebt();
    </script>
</body>
</html>
