<?php

require_once __DIR__ . '/vendor/autoload.php';

// Check if the form was submitted
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
    // Capture form input
    $amount = isset( $_POST[ 'amount' ] ) ? $_POST[ 'amount' ] : '';
    $from = isset( $_POST[ 'from' ] ) ? $_POST[ 'from' ] : '';
    $description = isset( $_POST[ 'description' ] ) ? $_POST[ 'description' ] : '';
    $external_reference = bin2hex( random_bytes( 12 ) ) . '-' . $from;
    // $external_reference = 'c49f98683f51fd5da3105e4d-677228619';

    // Prepare the request body
    $body = json_encode( [
        'amount' => $amount,
        'from' => '237' . $from,
        'description' => $description,
        'external_reference' => $external_reference,
        'redirect_url' => $_SERVER[ 'HTTP_HOST' ] . '/camPayAPI/response.php'
    ], JSON_UNESCAPED_SLASHES );

    try {
        $request = new HTTP_Request2();
        $request->setUrl( 'https://demo.campay.net/api/collect/' );
        $request->setMethod( HTTP_Request2::METHOD_POST );
        $request->setConfig( [
            'follow_redirects' => TRUE
        ] );
        $request->setHeader( [
            'Authorization' => 'Token 18872ca237c8145897dae2a9ceeb3e26821bf8b9',
            'Content-Type' => 'application/json'
        ] );
        $request->setBody( $body );

        // Send the request and get the response
        $response = $request->send();
        $response_body = json_decode( $response->getBody(), true );

        // Check the response and redirect to the waiting page with the external reference
        if ( $response->getStatus() == 200 ) {
            header( 'Location: waiting.php?reference=' . urlencode( $response_body[ 'reference' ] ) );
            exit();
        } else {
            // Handle failed request
            echo 'Payment request failed. Please try again later.';
        }
    } catch ( HTTP_Request2_Exception $e ) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
