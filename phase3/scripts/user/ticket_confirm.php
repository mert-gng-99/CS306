<?php
// ticket confirmation page
// shows result after creating a ticket

require_once 'mongo_config.php';

$success = false;
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $ticket_message = isset($_POST['message']) ? trim($_POST['message']) : '';

    if ($username && $ticket_message) {
        $success = createTicket($mongoManager, $username, $ticket_message);
        if ($success) {
            $message = "Ticket created successfully!";
        } else {
            $message = "Error creating ticket. Please try again.";
        }
    } else {
        $message = "Please fill in all fields.";
    }
} else {
    $message = "No data received.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
        }

        h2 {
            color: #333;
        }

        .result-box {
            border: 1px solid #000;
            padding: 20px;
            margin: 20px 0;
            background: #f9f9f9;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        .nav-link {
            color: #0066cc;
            text-decoration: underline;
            margin-right: 15px;
        }
    </style>
</head>

<body>
    <h2>Ticket Confirmation</h2>

    <div class="result-box">
        <p class="<?php echo $success ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </p>
    </div>

    <p>
        <a href="create_ticket.php" class="nav-link">Create Another Ticket</a>
        <a href="tickets.php" class="nav-link">View All Tickets</a>
    </p>
</body>

</html>