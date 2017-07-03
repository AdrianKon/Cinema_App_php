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
$name = urldecode($_GET['name']);
$surname = urldecode($_GET['surname']);
$result;
$is_Existing;

$connectionInfo = array("UID" => "kinoadmin@superkinoserwer", "pwd" => "11Koksy11", "Database" => "superkino", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:superkinoserwer.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);

$sql_1 = "SELECT * FROM klient where email = '$email' and haslo = '$password'";
$stmt_1 = sqlsrv_query ( $conn , $sql_1 );
if( $stmt_1 === false ) {
     die( print_r( sqlsrv_errors(), true));
	 //$is_Existing = false;
}else{
	//$row = sqlsrv_fetch_array ( $stmt_1, SQLSRV_FETCH_ASSOC );
	$cos = sqlsrv_num_rows($stmt_1);
	print($cos);
	if(sqlsrv_num_rows($stmt_1) >= 1){
		$is_Existing = true;
	}else {
		$is_Existing = false;
	}
}

if ($is_Existing === false){
	$sql = "INSERT INTO [dbo].[Klient]
			   ([email]
			   ,[haslo]
			   ,[imie]
			   ,[nazwisko])
		 VALUES
				('$email'
				,'$password'
				,'$name'
				,'$surname'
				)";
	$stmt = sqlsrv_query ( $conn , $sql );
	if( $stmt === false ) {
		 die( print_r( sqlsrv_errors(), true));
		 $result = false;
	}else{
		//$row = sqlsrv_fetch_array ( $stmt, SQLSRV_FETCH_ASSOC );
		$result = true;
	}
}else{
	$result = false;
}
echo json_encode($result);
?>