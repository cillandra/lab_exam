<?php
    $consumer_name = htmlspecialchars($_POST['consumer_name']);
    $previous_reading = floatval($_POST['previous_reading']);
    $current_reading = floatval($_POST['current_reading']);
    $consumer_type = $_POST['consumer_type'];

    $usage = $current_reading - $previous_reading;
    $invalid = $usage < 0;

    if (!$invalid) {
        if ($usage <= 200) {
            $rate = 10.00;
        } else {
            $rate = 15.00;
        }
        $electricity_charge = $usage * $rate;

        $surcharge = ($consumer_type === 'commercial') ? 500.00 : 0.00;

        $total_bill = $electricity_charge + $surcharge;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Result - Eco-Friendly Electric Bill App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <header><h3>Eco-Friendly Electric Bill App</h3></header>

        <?php if ($invalid): ?>
            <div class="alert alert-danger text-center" role="alert">
                <strong>Invalid Reading:</strong> Current reading cannot be lower than previous.
            </div>
        <?php else: ?>
            <div class="bill-result">
                <h5 class="text-center mb-3">Bill Summary</h5>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Consumer Name</th>
                            <td><?= $consumer_name ?></td>
                        </tr>
                        <tr>
                            <th>Consumer Type</th>
                            <td><?= ucfirst($consumer_type) ?></td>
                        </tr>
                        <tr>
                            <th>Previous Reading</th>
                            <td><?= number_format($previous_reading, 2) ?> kWh</td>
                        </tr>
                        <tr>
                            <th>Current Reading</th>
                            <td><?= number_format($current_reading, 2) ?> kWh</td>
                        </tr>
                        <tr>
                            <th>Usage</th>
                            <td><?= number_format($usage, 2) ?> kWh</td>
                        </tr>
                        <tr>
                            <th>Rate</th>
                            <td>₱<?= number_format($rate, 2) ?> / kWh
                                <small class="text-muted">(<?= $usage <= 200 ? 'Low usage ≤ 200 kWh' : 'High usage > 200 kWh' ?>)</small>
                            </td>
                        </tr>
                        <tr>
                            <th>Electricity Charge</th>
                            <td>₱<?= number_format($electricity_charge, 2) ?></td>
                        </tr>
                        <?php if ($consumer_type === 'commercial'): ?>
                        <tr>
                            <th>Service Charge (Commercial)</th>
                            <td>₱<?= number_format($surcharge, 2) ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr class="table-success fw-bold">
                            <th>Total Bill</th>
                            <td>₱<?= number_format($total_bill, 2) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <a href="index.html" class="btn w-100 mt-2">← Calculate Another Bill</a>
    </div>
</body>
</html>