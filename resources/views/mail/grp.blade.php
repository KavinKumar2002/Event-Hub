<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Registration Confirmation</title>
    <style>
        /* Add your custom CSS styles here */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f2f2f2; /* Light gray background */
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff; /* White background */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Soft shadow effect */
        }
        h2 {
            color: #007bff; /* Blue heading */
            margin-top: 0;
        }
        p {
            margin-bottom: 16px;
            color: #666; /* Gray text */
        }
        ul {
            margin-bottom: 16px;
            padding-left: 20px;
        }
        li {
            list-style-type: disc;
            margin-bottom: 8px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff; /* Blue button */
            color: #fff; /* White text */
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Team Registration Confirmation</h2>
        <p>Dear {{ $name }},</p>
        <p>Thank you for registering your team {{ $teamname }} for the event {{ $eventname }}.</p>
        <p>Your team's registration has been confirmed.</p>
        <p>Event Details:</p>
        <ul>
            <li><strong>Event Name:</strong> {{ $eventname }}</li>
        </ul>
        <p>If you have any questions or concerns, feel free to contact us.</p>
        <p>Best regards,<br>Karpagam Institute Of Technology</p>
    </div>
</body>
</html>
