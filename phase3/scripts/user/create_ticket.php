<?php
// Create Ticket Page

require_once 'mongo_config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a Ticket</title>
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

        .nav-links {
            margin-bottom: 20px;
        }

        .nav-link {
            color: #0066cc;
            text-decoration: underline;
            margin-right: 15px;
        }

        .form-box {
            margin: 20px 0;
        }

        .form-row {
            margin: 10px 0;
        }

        input[type="text"],
        textarea {
            width: 100%;
            max-width: 300px;
            padding: 8px;
            border: 1px solid #999;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        .submit-btn {
            padding: 8px 20px;
            background: #e0e0e0;
            border: 1px solid #999;
            cursor: pointer;
            margin-top: 10px;
        }

        .submit-btn:hover {
            background: #d0d0d0;
        }
    </style>
</head>

<body>
    <div class="nav-links">
        <a href="tickets.php" class="nav-link">View Tickets</a>
        <a href="index.php" class="nav-link">Home</a>
    </div>

    <h2>Create a Ticket</h2>

    <div class="form-box">
        <form method="POST" action="ticket_confirm.php">
            <div class="form-row">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="form-row">
                <textarea name="message" placeholder="this will be my second ticket" required></textarea>
            </div>
            <button type="submit" class="submit-btn">Create Ticket</button>
        </form>
    </div>
</body>

</html>