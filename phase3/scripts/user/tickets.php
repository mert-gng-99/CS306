<?php
// support tickets - list page
// shows tickets with dropdown to select username

require_once 'mongo_config.php';

$selected_username = isset($_GET['username']) ? $_GET['username'] : '';
$tickets = [];
$all_usernames = [];

// get all unique usernames with active tickets
$all_tickets = getTickets($mongoManager, null, true);
foreach ($all_tickets as $t) {
    if (!in_array($t->username, $all_usernames)) {
        $all_usernames[] = $t->username;
    }
}

// get tickets for selected username
if ($selected_username) {
    $tickets = getTickets($mongoManager, $selected_username, true);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Tickets</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
        }

        h2 {
            color: #333;
            margin-top: 20px;
        }

        .nav-links {
            margin-bottom: 20px;
        }

        .nav-link {
            color: #0066cc;
            text-decoration: underline;
            margin-right: 15px;
        }

        .select-section {
            margin: 20px 0;
        }

        select {
            padding: 5px;
            border: 1px solid #999;
        }

        .select-btn {
            padding: 5px 15px;
            background: #e0e0e0;
            border: 1px solid #999;
            cursor: pointer;
            margin-left: 10px;
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
    <div class="nav-links">
        <a href="index.php" class="nav-link">Homepage</a>
        <a href="create_ticket.php" class="nav-link">Create a Ticket</a>
    </div>

    <div class="select-section">
        <form method="GET">
            <select name="username">
                <option value="">-- Select --</option>
                <?php foreach ($all_usernames as $uname): ?>
                    <option value="<?php echo htmlspecialchars($uname); ?>" <?php echo ($selected_username == $uname) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($uname); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="select-btn">Select</button>
        </form>
    </div>

    <div class="result-box">
        <strong>Results:</strong>

        <?php if ($selected_username && count($tickets) > 0): ?>
            <?php foreach ($tickets as $ticket): ?>
                <div class="ticket-item">
                    <p><strong>Username:</strong> <?php echo htmlspecialchars($ticket->username); ?></p>
                    <p><strong>Created At:</strong> <?php echo htmlspecialchars($ticket->created_at); ?></p>
                    <p><a href="ticket_detail.php?id=<?php echo (string) $ticket->_id; ?>" class="ticket-link">View Details</a>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php elseif ($selected_username): ?>
            <p class="no-tickets">No active tickets for this user.</p>
        <?php else: ?>
            <p class="no-tickets">Select a username to see tickets.</p>
        <?php endif; ?>
    </div>
</body>

</html>