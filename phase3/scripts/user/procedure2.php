<?php
// stored procedure 2: scheduleflight
// creates a new flight with user inputs

require_once 'db_config.php';

$message = "";

// handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $param1 = $conn->real_escape_string($_POST['parameter1']); // flight number
    $param2 = $conn->real_escape_string($_POST['parameter2']); // departure
    $param3 = $conn->real_escape_string($_POST['parameter3']); // arrival
    $param4 = $conn->real_escape_string($_POST['parameter4']); // aircraft

    if ($param1 && $param2 && $param3 && $param4) {
        // call the stored procedure
        $sql = "CALL ScheduleFlight('$param1', '$param2', '$param3', '$param4')";
        $result = $conn->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();
            $message = "SUCCESS: " . $row['status'];
            $result->free();
            while ($conn->more_results()) {
                $conn->next_result();
            }
        } else {
            $message = "ERROR: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stored Procedure 2</title>
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
    </style>
</head>

<body>
    <div class="proc-box">
        <div class="proc-title">Stored Procedure 2 (by Agent Smith): This is another sample stored procedure description
        </div>
        <form method="POST">
            <div class="param-row">
                <span class="param-label">Parameter 1</span>
                <input type="text" name="parameter1" class="param-input" placeholder="Flight Number (e.g. TK999)"
                    required>
            </div>
            <div class="param-row">
                <span class="param-label">Parameter 2</span>
                <input type="text" name="parameter2" class="param-input"
                    placeholder="Departure (e.g. 2025-12-28 10:00:00)" required>
            </div>
            <div class="param-row">
                <span class="param-label">Parameter 3</span>
                <input type="text" name="parameter3" class="param-input"
                    placeholder="Arrival (e.g. 2025-12-28 14:00:00)" required>
            </div>
            <div class="param-row">
                <span class="param-label">Parameter 4</span>
                <input type="text" name="parameter4" class="param-input" placeholder="Aircraft ID (e.g. TC-JNA)"
                    required>
            </div>
            <button type="submit" class="call-btn">Call Procedure</button>
        </form>
    </div>

    <p><a href="index.php" class="nav-link">Go to homepage</a></p>

    <?php if ($message): ?>
        <div class="result">
            <strong>Result:</strong> <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>
</body>

</html>
<?php $conn->close(); ?>