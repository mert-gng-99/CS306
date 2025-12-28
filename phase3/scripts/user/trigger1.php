<?php
// trigger 1: check capacity before insert
// stops booking if flight is full

require_once 'db_config.php';

$message = "";
$result_data = [];

// handle button clicks
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['case'])) {
    $case = $_POST['case'];

    if ($case == 1) {
        // case 1: try to book on a flight with space
        $sql = "INSERT INTO Booking (passenger_id_fk, flight_number_fk, seat_number, booking_date) 
                VALUES (1, 'QR240', '30A', CURDATE())";
        if ($conn->query($sql) === TRUE) {
            $message = "SUCCESS: Booking added to flight QR240 (has space available)";
        } else {
            $message = "ERROR: " . $conn->error;
        }
    } elseif ($case == 2) {
        // case 2: show current booking count
        $sql = "SELECT F.flight_number, A.capacity, COUNT(B.passenger_id_fk) as booked
                FROM Flight F
                JOIN Aircraft A ON F.aircraft_id_fk = A.aircraft_id
                LEFT JOIN Booking B ON F.flight_number = B.flight_number_fk
                GROUP BY F.flight_number, A.capacity";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $result_data[] = $row;
        }
        $message = "Showing current flight capacity status";
    } elseif ($case == 3) {
        // case 3: delete the test booking
        $sql = "DELETE FROM Booking WHERE flight_number_fk = 'QR240' AND seat_number = '30A'";
        $conn->query($sql);
        $message = "Test booking removed (if it existed)";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trigger 1</title>
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
        <div class="trigger-title">Trigger 1 (by Mert Güngör): This is a sample trigger description</div>
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
                        <th>Flight</th>
                        <th>Capacity</th>
                        <th>Booked</th>
                        <th>Available</th>
                    </tr>
                    <?php foreach ($result_data as $row): ?>
                        <tr>
                            <td><?php echo $row['flight_number']; ?></td>
                            <td><?php echo $row['capacity']; ?></td>
                            <td><?php echo $row['booked']; ?></td>
                            <td><?php echo $row['capacity'] - $row['booked']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</body>

</html>
<?php $conn->close(); ?>