<?php
// stored procedure 1: getpassengermanifest
// shows passenger list for a flight

require_once 'db_config.php';

$passengers = [];
$message = "";

// handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $param1 = isset($_POST['parameter1']) ? $conn->real_escape_string($_POST['parameter1']) : '';

    if ($param1) {
        // call the stored procedure
        $sql = "CALL GetPassengerManifest('$param1')";
        $result = $conn->query($sql);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $passengers[] = $row;
            }
            $result->free();
            while ($conn->more_results()) {
                $conn->next_result();
            }
            $message = "Results for flight: " . $param1;
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stored Procedure 1</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
        }

        .proc-box {
            border: 1px solid #000;
            padding: 15px;
            margin: 20px 0;
            background: #f9f9f9;
        }

        .proc-title {
            font-weight: bold;
            margin-bottom: 15px;
        }

        .param-row {
            margin: 10px 0;
        }

        .param-label {
            display: inline-block;
            width: 100px;
        }

        .param-input {
            padding: 5px;
            width: 200px;
            border: 1px solid #999;
        }

        .call-btn {
            margin-top: 10px;
            padding: 5px 15px;
            background: #e0e0e0;
            border: 1px solid #999;
            cursor: pointer;
        }

        .call-btn:hover {
            background: #d0d0d0;
        }

        .nav-link {
            color: #0066cc;
            text-decoration: underline;
        }

        .result {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            background: #fff;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #f0f0f0;
        }
    </style>
</head>

<body>
    <div class="proc-box">
        <div class="proc-title">Stored Procedure 1 (by Thorin Oakenshield): This is a sample stored procedure
            description</div>
        <form method="POST">
            <div class="param-row">
                <span class="param-label">Parameter 1</span>
                <input type="text" name="parameter1" class="param-input" placeholder="e.g. TK001" required>
            </div>
            <button type="submit" class="call-btn">Call Procedure</button>
        </form>
    </div>

    <p><a href="index.php" class="nav-link">Go to homepage</a></p>

    <?php if ($message): ?>
        <div class="result">
            <strong><?php echo htmlspecialchars($message); ?></strong>

            <?php if (count($passengers) > 0): ?>
                <table>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Seat Number</th>
                    </tr>
                    <?php foreach ($passengers as $p): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($p['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($p['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($p['seat_number']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>No passengers found for this flight.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</body>

</html>
<?php $conn->close(); ?>