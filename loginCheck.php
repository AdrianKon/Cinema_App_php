<?php

//session_start();  //sesja narazie nie używana

try {
    $conn = new PDO("sqlsrv:server = tcp:superkinoserwer.database.windows.net,1433; Database = superkino", "kinoadmin", "11Koksy11");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}

$email = urldecode($_GET['email']);
$password = urldecode($_GET['password']);
$result;

$connectionInfo = array("UID" => "kinoadmin@superkinoserwer", "pwd" => "11Koksy11", "Database" => "superkino", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:superkinoserwer.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);

$sql = "SELECT * FROM klient where email = '$email' and haslo = '$password'";
$stmt = sqlsrv_query ( $conn , $sql );
if( $stmt === false ) {
     die( print_r( sqlsrv_errors(), true));
	 $result = false;
}else{
	$row = sqlsrv_fetch_array ( $stmt, SQLSRV_FETCH_ASSOC );
	$result = true;
}
echo json_encode($result)

?>