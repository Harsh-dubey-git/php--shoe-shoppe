<?php
function fetch_api($endpoint, $params = []) {
    $url = 'http://localhost:5000' . $endpoint;
    if (!empty($params)) {
        $url .= '?' . http_build_query($params);
    }

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec($ch);
    curl_close($ch);
    return json_decode($res, true);
}

// Fetch data
$salesForecastRaw = fetch_api('/api/sales-forecast');
$customerSegments = fetch_api('/api/segment-customers');
$churnPrediction = fetch_api('/api/predict-churn', [
    'user_data[]' => 45,
    'user_data[]' => 20000,
    'user_data[]' => 3
]);

// Extract data for chart
$salesDates = array_map(fn($item) => date('d M', strtotime($item['ds'])), $salesForecastRaw);
$salesYhat = array_map(fn($item) => $item['yhat'], $salesForecastRaw);

// For Pie Chart: Customer Segments
$segmentLabels = array_map(fn($k) => "Segment $k", array_keys($customerSegments['segments'] ?? []));
$segmentValues = array_values($customerSegments['segments'] ?? []);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>📊 E-commerce AI Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@700&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <style>
        .container {
            margin-top: 50px;
        }

        * {
            font-family: 'Quicksand', sans-serif;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        canvas { max-width: 100%; margin: 2rem auto; }
        .icon { width: 24px; height: 24px; vertical-align: middle; margin-right: 8px; }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <h3>Analytic Reports</h3>
    <div class="row g-4 py-80">
        <!-- Sales Forecast -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-center"><i data-lucide="line-chart" class="icon"></i>Sales Forecast</h5>
                    <canvas id="salesChart" style="height: 250px; width: 100%"></canvas>
                </div>
            </div>
        </div>

        <!-- Customer Segments -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-center"><i data-lucide="users" class="icon"></i>Customer Segments</h5>
                    <canvas id="segmentChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Churn Prediction Gauge -->
        <div class="col-md-6 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title"><i data-lucide="activity" class="icon"></i>Churn Prediction</h5>
                    <canvas id="churnChart" style="height: 150px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();

    // Sales Forecast Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: <?= json_encode($salesDates) ?>,
            datasets: [{
                label: 'Predicted Sales',
                data: <?= json_encode($salesYhat) ?>,
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                pointBackgroundColor: '#0d6efd',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        label: context => `₹${context.raw.toFixed(2)}`
                    }
                }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Customer Segments Pie Chart
    const segmentCtx = document.getElementById('segmentChart').getContext('2d');
    new Chart(segmentCtx, {
        type: 'pie',
        data: {
            labels: <?= json_encode($segmentLabels) ?>,
            datasets: [{
                label: 'Customer Segments',
                data: <?= json_encode($segmentValues) ?>,
                backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6610f2']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: context => `${context.label}: ${context.raw} customers`
                    }
                }
            }
        }
    });

    // Churn Prediction Gauge Chart
    const churnCtx = document.getElementById('churnChart').getContext('2d');
    new Chart(churnCtx, {
        type: 'doughnut',
        data: {
            labels: ['Low Risk', 'High Risk'],
            datasets: [{
                data: [<?= $churnPrediction['churn_prediction'] === 1 ? '0' : '1' ?>, <?= $churnPrediction['churn_prediction'] === 1 ? '1' : '0' ?>],
                backgroundColor: ['#28a745', '#dc3545'],
                borderColor: '#ffffff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            rotation: Math.PI, // Inverted start of doughnut
            cutoutPercentage: 70, // Makes it a doughnut chart (more like a gauge)
            plugins: {
                legend: { position: 'bottom' },
                tooltip: { enabled: false }
            }
        }
    });
</script>

</body>
</html>
