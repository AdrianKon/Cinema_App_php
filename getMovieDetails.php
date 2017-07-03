<?php
try {
    $conn = new PDO("sqlsrv:server = tcp:superkinoserwer.database.windows.net,1433; Database = superkino", "kinoadmin", "11Koksy11");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}

$dayOfTheWeek = urldecode($_GET['dayOfTheWeek']);
$searchedDate;
$movies = array();
$i = 0;
$movies_size;
$results = array();

$connectionInfo = array("UID" => "kinoadmin@superkinoserwer", "pwd" => "11Koksy11", "Database" => "superkino", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:superkinoserwer.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);

$sql = "SELECT dzien FROM seans";
$stmt = sqlsrv_query ( $conn , $sql );
if( $stmt === false ) {
     die( print_r( sqlsrv_errors(), true));
	 //$result = false;
}else{
	while(   $row = sqlsrv_fetch_array ( $stmt, SQLSRV_FETCH_ASSOC )   ){
		$date = ($row['dzien']);
		$dateString = $date->format('Y-m-d');		
		if(date('w', strtotime($dateString)) == $dayOfTheWeek){
			$searchedDate = date('Y-m-d', strtotime($dateString));
			$sql2 = "SELECT id_filmu FROM seans where dzien = '$searchedDate'";
			$stmt2 = sqlsrv_query ( $conn , $sql2 );
			if( $stmt2 === false ) {
				die( print_r( sqlsrv_errors(), true));
			}else{
				while(   $row2 = sqlsrv_fetch_array ( $stmt2, SQLSRV_FETCH_ASSOC )   ){
					$movies[$i] = $row2['id_filmu'];
					$i++;
				}
				$movies_size = count($movies);
				for ($x = 0; $x < $movies_size; $x++){
					$sql3 = "SELECT tytul,gatunek,opis FROM film where id_filmu = '$movies[$x]'";
					$stmt3 = sqlsrv_query ( $conn , $sql3 );
					if( $stmt3 === false ) {
						 die( print_r( sqlsrv_errors(), true));
					}else{
						while(   $row3 = sqlsrv_fetch_array ( $stmt3, SQLSRV_FETCH_ASSOC )   ){
							$results[] = $row3;
						//$results[] = '{"title": ['$row3["tytul"]'], "genre": [$row3["gatunek"]], "description": [$row3["opis"]]}';
						}							
					}
				}
			}
			break;
		}
	}
	//$result = true;
}
//echo $results[0]['tytul'].$results[0]['gatunek'].$results[0]['opis'];
//echo $results[1]['tytul'];
//echo $results[0]['data'];
echo json_encode($results);

?>