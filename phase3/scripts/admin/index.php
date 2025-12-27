<?php
// Admin Homepage - Shows ALL active tickets from ALL users

require_once 'mongo_config.php';

$tickets = getAllActiveTickets($mongoManager);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Support Tickets</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
        }

        h2 {
            color: #333;
        }

        .result-box {
            border: 1px solid #000;
            padding: 15px;
            margin: 20px 0;
            background: #f9f9f9;
        }

        .ticket-item {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px 0;
            background: white;
        }

        .ticket-item p {
            margin: 5px 0;
        }

        .ticket-link {
            color: #0066cc;
            text-decoration: underline;
        }

        .no-tickets {
            color: #666;
            font-style: italic;
        }
    </style>
</head>

<body>
    <h2>Admin - All Active Tickets</h2>

    <div class="result-box">
        <?php if (count($tickets) > 0): ?>
            <?php foreach ($tickets as $ticket): ?>
                <div class="ticket-item">
                    <p><strong>Username:</strong> <?php echo htmlspecialchars($ticket->username); ?></p>
                    <p><strong>Body:</strong> <?php echo htmlspecialchars(substr($ticket->message, 0, 100)); ?></p>
                    <p><strong>Created At:</strong> <?php echo htmlspecialchars($ticket->created_at); ?></p>
                    <p><a href="ticket_detail.php?id=<?php echo (string) $ticket->_id; ?>" class="ticket-link">View Details</a>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-tickets">No active tickets.</p>
        <?php endif; ?>
    </div>
</body>

</html>