<?php
// Ticket Detail Page - View and add comments

require_once 'mongo_config.php';

$ticket_id = isset($_GET['id']) ? $_GET['id'] : '';
$message = "";

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $comment = trim($_POST['comment']);
    if ($comment && $ticket_id) {
        $success = addComment($mongoManager, $ticket_id, $comment, 'user');
        if ($success) {
            $message = "Comment added!";
        }
    }
}

// Get ticket details
$ticket = null;
if ($ticket_id) {
    $ticket = getTicketById($mongoManager, $ticket_id);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Details</title>
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

        .nav-link {
            color: #0066cc;
            text-decoration: underline;
        }

        .detail-box {
            border: 1px solid #000;
            padding: 15px;
            margin: 20px 0;
            background: #f9f9f9;
        }

        .detail-row {
            margin: 8px 0;
        }

        .label {
            font-weight: bold;
        }

        .comment-section {
            border: 1px solid #000;
            padding: 15px;
            margin: 20px 0;
            background: #f9f9f9;
        }

        .comment-item {
            border: 1px solid #ccc;
            padding: 8px;
            margin: 5px 0;
            background: white;
        }

        .comment-form {
            margin-top: 15px;
        }

        .comment-input {
            width: 100%;
            max-width: 400px;
            padding: 8px;
            border: 1px solid #999;
        }

        .add-btn {
            padding: 5px 15px;
            background: #e0e0e0;
            border: 1px solid #999;
            cursor: pointer;
        }

        .add-btn:hover {
            background: #d0d0d0;
        }
    </style>
</head>

<body>
    <h2>Ticket Details</h2>

    <?php if ($ticket): ?>
        <div class="detail-box">
            <div class="detail-row"><span class="label">Username:</span> <?php echo htmlspecialchars($ticket->username); ?>
            </div>
            <div class="detail-row"><span class="label">Body:</span> <?php echo htmlspecialchars($ticket->message); ?></div>
            <div class="detail-row"><span class="label">Status:</span>
                <?php echo $ticket->status ? 'Active' : 'Resolved'; ?></div>
            <div class="detail-row"><span class="label">Created At:</span>
                <?php echo htmlspecialchars($ticket->created_at); ?></div>
        </div>

        <div class="comment-section">
            <h3>Comments:</h3>
            <?php if (count($ticket->comments) > 0): ?>
                <?php foreach ($ticket->comments as $comment): ?>
                    <div class="comment-item"><?php echo htmlspecialchars($comment); ?></div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No comments yet.</p>
            <?php endif; ?>

            <?php if ($ticket->status): ?>
                <div class="comment-form">
                    <form method="POST">
                        <input type="text" name="comment" class="comment-input" placeholder="Add a comment..." required>
                        <br><br>
                        <button type="submit" class="add-btn">Add Comment</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <p>Ticket not found.</p>
    <?php endif; ?>

    <p><a href="tickets.php" class="nav-link">Back to Tickets</a></p>
</body>

</html>