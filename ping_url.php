<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', 'C:\TEMP_DELETE\logs.log');  // Adjust the path as needed


function sendCode($code){
    header("Content-type: application/json\n\n");
    echo json_encode(array("code" => $code));
    exit();
}

function sendError($error){
    header("Content-type: application/json\n\n");
    echo json_encode(array("error" => $error));
    exit();
}
function sendPostBody($body){
    header("Content-type: application/json\n\n");
    echo json_encode(array("body" => $body));
    exit();
}

function pingURL($url, $timeout = 5) {
    try {
        $ch = curl_init($url);

        if ($ch === false) {
            throw new Exception('Failed to initialize cURL session');
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
        //curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);  // total time to fetch the URL
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); // time to wait for connection
        curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception('CURL Error: ' . curl_error($ch));
        }
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $http_code;
    } catch (Exception $e) {
        sendError('Error: ' . $e->getMessage());
        return false;
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Get raw POST data
    $postData = file_get_contents("php://input");
    //$postData = $_POST['url'];
    //sendPostBody($postData);
    if (!$postData) {
        sendError("No POST data provided");
    }
    try{
        $data = json_decode($postData, true);
    }catch(e){
        sendError('Error: ' . e);
    }
    if (!isset($data['url']) || !filter_var($data['url'], FILTER_VALIDATE_URL)) {
        sendError("Invalid or missing URL");
    }
    if(!isset($data['timeout'])){
        sendError("Invalid or missing timeout");
    }

    $url = $data['url'];
    $timeout = $data['timeout'];
    $http_code = pingURL($url, $timeout);
    sendCode($http_code);
} else {
    sendError("Invalid request method");
}
?>
