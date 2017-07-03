<?php
// PHP Data Objects(PDO) Sample Code:
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

// SQL Server Extension Sample Code:
$connectionInfo = array("UID" => "kinoadmin@superkinoserwer", "pwd" => "11Koksy11", "Database" => "superkino", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:superkinoserwer.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);

$sql = "Select opis from Film where id_filmu = 1";
$stmt = sqlsrv_query ( $conn , $sql );
if( $stmt === false ) {
     die( print_r( sqlsrv_errors(), true));
}else{
	$row = sqlsrv_fetch_array ( $stmt, SQLSRV_FETCH_ASSOC );
}
//echo $row['opis'];
//echo "worked";
//echo $row['opis'];
echo $email;
?>