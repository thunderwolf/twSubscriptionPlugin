<?php

/**
 * @link        http://www.phpfour.com
 */

$action = 'http://^APP_BASE_URL^/twSubscriptionApi/ajax/id/^LIST_ID^';
$shared_key = '^SHARED_KEY^';

// Submission method
$method = (isset($_REQUEST['method']) ? $_REQUEST['method'] : 'GET');

// Query string
$fields = '';

// Prepare the fields for query string, don't include the action URL OR method
if (count($_REQUEST) > 1) {
    foreach ($_REQUEST as $key => $value) {
        if ($key != 'url' || $key != 'method') {
            $fields .= $key . '=' . rawurlencode($value) . '&';
        }
    }
}

$fields .= 'shared_key=' . rawurlencode($shared_key) . '&';

// Strip the last comma
$fields = substr($fields, 0, strlen($fields) - 1);

// Initiate cURL
$ch = curl_init();

// Do we need to POST of GET ?
if (strtoupper($method) == 'POST') {
    curl_setopt($ch, CURLOPT_URL, $action);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
} else {
    curl_setopt($ch, CURLOPT_URL, $action . '?' . $fields);
}

// Follow redirects and return the transfer
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

// Get result and close cURL
$result = curl_exec($ch);
curl_close($ch);

$json = @json_decode($result, true);
if (isset($json['redir']) && $json['redir_auth'] == sha1($json['redir'] . 0xDEADBEEF . $shared_key)) {
    header('Location: ' . $json['redir']);
    exit;
}

// Return the response
echo $result;
