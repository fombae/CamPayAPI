
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
        <?php

            // Get the reference from URL
            $reference = isset( $_GET[ 'reference' ] ) ? $_GET[ 'reference' ] : '';
            $status = isset( $_GET[ 'status' ] ) ? $_GET[ 'status' ] : '';

            if ( $status == 'SUCCESSFUL' ) {
                $message = 'Payment Successful!';
            } elseif ( $status == 'FAILED' ) {
                $message = 'Payment Failed!';
            } elseif ( $status == 'PENDING' ) {
                $message = 'Payment Pending!';
            } else {
                $message = 'Payment status unknown.';
            }

            echo '<h1>Payment Status</h1>';
            echo '<p>Reference: ' . htmlspecialchars( $reference ) . '</p>';
            echo '<p>Status: ' . $message . '</p>';


            ?>

        </div>
    </body>
</html>