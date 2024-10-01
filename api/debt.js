let debt = 1000;
let lastUpdate = Date.now();

export default function handler(req, res) {
    const now = Date.now();
    const elapsedHours = (now - lastUpdate) / (1000 * 60 * 60); // Час в годинах

    if (elapsedHours >= 24) {
        const periods = Math.floor(elapsedHours / 24);
        debt *= Math.pow(1.05, periods); // Збільшення боргу на 5% кожні 24 години
        lastUpdate += periods * 24 * 60 * 60 * 1000; // Оновлення часу останнього оновлення
    }

    res.status(200).json({ debt: debt.toFixed(2), lastUpdate });
}
