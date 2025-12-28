<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Homepage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
        }

        h1 {
            color: #333;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        h2 {
            color: #333;
            margin-top: 30px;
        }

        .section {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ccc;
            background: #f9f9f9;
        }

        .item {
            margin: 10px 0;
            padding: 10px;
            background: white;
            border: 1px solid #ddd;
        }

        .item-title {
            font-weight: bold;
            color: #0066cc;
        }

        .item-title a {
            color: #0066cc;
            text-decoration: underline;
        }

        .item-desc {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }

        .person {
            color: #888;
            font-style: italic;
            font-size: 13px;
        }

        .nav-link {
            color: #0066cc;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h1>User Homepage</h1>

    <h2>Triggers:</h2>
    <div class="section">
        <div class="item">
            <div class="item-title">
                <a href="trigger1.php">Trigger 1 (by Mert Güngör)</a>: This is a sample trigger description
            </div>
            <div class="item-desc">Checks flight capacity before booking</div>
        </div>
        <div class="item">
            <div class="item-title">
                <a href="trigger2.php">Trigger 2 (by Kaan Berk Karabıyık)</a>: This is another sample trigger
                description
            </div>
            <div class="item-desc">Logs deleted bookings to Booking_Log table</div>
        </div>
    </div>

    <h2>Stored Procedures:</h2>
    <div class="section">
        <div class="item">
            <div class="item-title">
                <a href="procedure1.php">Stored Procedure 1 (by Mert Güngör)</a>: This is a sample stored
                procedure description
            </div>
            <div class="item-desc">Gets passenger manifest for a flight</div>
        </div>
        <div class="item">
            <div class="item-title">
                <a href="procedure2.php">Stored Procedure 2 (by Kaan Berk Karabıyık)</a>: This is another sample stored
                procedure description
            </div>
            <div class="item-desc">Schedules a new flight</div>
        </div>
    </div>

    <p style="margin-top: 30px;">
        <a href="tickets.php" class="nav-link">Support Tickets</a>
    </p>
</body>

</html>