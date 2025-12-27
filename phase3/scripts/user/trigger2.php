<?php
// Trigger 2: Log Booking Delete
// This trigger logs deleted bookings to Booking_Log table

require_once 'db_config.php';

$message = "";
$result_data = [];

// Handle button clicks
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['case'])) {
    $case = $_POST['case'];

    if ($case == 1) {
        // Case 1: Delete a booking to trigger the log
        $sql = "DELETE FROM Booking WHERE flight_number_fk = 'TK001' AND seat_number = '10F' LIMIT 1";
        if ($conn->query($sql) === TRUE && $conn->affected_rows > 0) {
            $message = "SUCCESS: Booking deleted. Check Booking_Log table for the log entry.";
        } else {
            $message = "No booking found to delete (may already be deleted)";
        }
    } elseif ($case == 2) {
        // Case 2: Show Booking_Log table
        $sql = "SELECT * FROM Booking_Log ORDER BY deleted_at DESC LIMIT 10";
        $result = $conn->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $result_data[] = $row;
            }
        }
        $message = "Showing Booking_Log table (filled by trigger)";
    } elseif ($case == 3) {
        // Case 3: Restore the test booking
        $sql = "INSERT IGNORE INTO Booking (passenger_id_fk, flight_number_fk, seat_number, booking_date) 
                VALUES (3, 'TK001', '10F', CURDATE())";
        $conn->query($sql);
        $message = "Test booking restored";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trigger 2</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        .trigger-box {
            border: 1px solid #000;
            padding: 15px;
            margin: 20px 0;
            background: #f9f9f9;
        }

        .trigger-title {
            font-weight: bold;
            margin-bottom: 15px;
        }

        .case-btn {
            display: block;
            margin: 5px 0;
            padding: 5px 15px;
            background: #e0e0e0;
            border: 1px solid #999;
            cursor: pointer;
            width: 80px;
        }

        .case-btn:hover {
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
    <div class="trigger-box">
        <div class="trigger-title">Trigger 2 (by Kaan Berk): This is a sample trigger description</div>
        <form method="POST">
            <button type="submit" name="case" value="1" class="case-btn">Case 1</button>
            <button type="submit" name="case" value="2" class="case-btn">Case 2</button>
            <button type="submit" name="case" value="3" class="case-btn">Case 3</button>
        </form>
    </div>

    <p><a href="index.php" class="nav-link">Go to homepage</a></p>

    <?php if ($message): ?>
        <div class="result">
            <strong>Result:</strong> <?php echo htmlspecialchars($message); ?>

            <?php if (count($result_data) > 0): ?>
                <table>
                    <tr>
                        <th>Log ID</th>
                        <th>Flight</th>
                        <th>Seat</th>
                        <th>Deleted At</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($result_data as $row): ?>
                        <tr>
                            <td><?php echo $row['log_id']; ?></td>
                            <td><?php echo $row['flight_number']; ?></td>
                            <td><?php echo $row['seat_number']; ?></td>
                            <td><?php echo $row['deleted_at']; ?></td>
                            <td><?php echo $row['user_action']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>No log entries yet.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</body>

</html>
<?php $conn->close(); ?>