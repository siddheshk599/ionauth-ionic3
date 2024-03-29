<?php

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400'); // cache for 1 day
}

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    }
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
        header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    }
    exit(0);

}

require "dbconnect.php";

$data = file_get_contents("php://input");

if (isset($data)) {
    $request = json_decode($data,true);
    $username = $request['username'];
}

$sql = "SELECT * FROM users WHERE username='$username';";

$result = mysqli_query($con, $sql);
$response = array();

while ($row = mysqli_fetch_array($result)) {
    array_push($response, array("id" => $row[0],
        "username" => $row[1],
        "password" => $row[2],
        "name" => $row[3],
        "mobile" => $row[4],
        "gender" => $row[5],
        "bday_Day" => $row[6],
        "bday_Month" => $row[7],
        "bday_Year" => $row[8]
        )
    );
}

echo json_encode(array("server_response" => $response));

mysqli_close($con)

?>
