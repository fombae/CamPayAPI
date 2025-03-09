<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div>
        <h1>Payment Intergration (camPayAPI)</h1>
        <form action="payment_send.php" method="POST">
            <label for="amount">Amount:</label>
            <input type="text" id="amount" name="amount" required><br>

            <label for="from">Phone Number (From):</label>
            <input type="text" id="from" name="from" required><br>

            <label for="description">Description:</label>
            <input type="text" id="description" name="description" required><br>

            <input type="submit" value="Submit Payment">
        </form>
    </div>
</body>
</html>
