<?php
require_once __DIR__ . '/vendor/autoload.php';

// Get the external reference from URL parameters
$external_reference = isset( $_GET[ 'reference' ] ) ? $_GET[ 'reference' ] : '';

// Validate that the reference exists
if ( empty( $external_reference ) ) {
    echo 'Invalid reference.';
    exit();
}

// Simulating a function to check the status of the payment from the API or database

function checkPaymentStatus( $external_reference )
 {
    try {
        $request = new HTTP_Request2();
        $request->setUrl( 'https://demo.campay.net/api/transaction/' . $external_reference . '/' );
        $request->setMethod( HTTP_Request2::METHOD_GET );
        $request->setConfig( [
            'follow_redirects' => TRUE
        ] );
        $request->setHeader( [
            'Authorization' => 'Token 18872ca237c8145897dae2a9ceeb3e26821bf8b9',
            'Content-Type' => 'application/json'
        ] );

        $response = $request->send();
        if ( $response->getStatus() == 200 ) {
            $response_body = json_decode( $response->getBody(), true );
            // Assuming response contains status, this could vary
            return $response_body[ 'status' ] ?? 'UNKNOWN';
        } else {
            return 'FAILED';
        }
    } catch ( HTTP_Request2_Exception $e ) {
        return 'FAILED';
    }
}

// Get the payment status
$status = checkPaymentStatus( $external_reference );
?>

<!DOCTYPE html>
<html lang = 'en'>
<head>
<meta charset = 'UTF-8'>
<meta name = 'viewport' content = 'width=device-width, initial-scale=1.0'>
<title>Waiting for Payment Status</title>
<link rel = 'stylesheet' href = 'main.css'>
<script>
// Function to check payment status

function checkStatus() {
    setTimeout( function() {
        // Reload the page to check the status again
        window.location.href = 'waiting.php?reference=<?php echo urlencode($external_reference); ?>';
    }
    , 20000 );
    // Reload every 20 seconds
}

// Redirect to response page when the status is available

function redirectToResponse( status ) {
    // Redirect to response.php with the status
    if ( status !== 'PENDING' ) {
        window.location.href = 'response.php?reference=<?php echo urlencode($external_reference); ?>&status=' + status;
    }
}

window.onload = function () {
    // Start checking status
    checkStatus();

    // If the status is not 'PENDING', redirect to the response page immediately
    const status = '<?php echo $status; ?>';
    if ( status !== 'PENDING' ) {
        redirectToResponse( status );
    }
}
;
</script>
</head>
<body>
<div>
<h1>Waiting for Payment Status</h1>
<p>Your payment request is being processed. Please wait...</p>

<p>If you are not redirected automatically, <a href = "response.php?reference=<?php echo urlencode($external_reference); ?>&status=<?php echo $status; ?>">click here</a>.</p>

</div>
</body>
</html>
