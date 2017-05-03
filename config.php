<?php

# MySQL server details
$MySQL['host']= "localhost";
$MySQL['un'] = "root";
$MySQL['pw'] = "";
$MySQL['db'] = "MySqlDB";
## MySQL server details

$MSSQL_C['host']= 'Darshee-Hp\SQLEXPRESS';
$MSSQL_C['info']= array( "Database"=>"test_sql");

$mssql = sqlsrv_connect( $MSSQL_C['host'], $MSSQL_C['info']);

// Create connection
$sqli = new mysqli($MySQL['host'], $MySQL['un'], $MySQL['pw'],$MySQL['db']);

// Check connection
if ($sqli->connect_error) {
    die("Connection failed: " . $sqli->connect_error);
} 
echo "MySQL Connected successfully";

function mypr($i){
	echo '<pre>';
	print_r($i);
	echo '</pre>';
}
function sql_list_tables(){
	global $mssql;
		$sql = "select table_name from information_schema.tables";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
		$stmt = sqlsrv_query( $mssql, $sql, $params, $options);
//		$row_count = sqlsrv_num_rows($stmt);
//		echo $row_count;

		$row_count = sqlsrv_num_rows( $stmt );
		   
	   $table['row']= $row_count;
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$table['table'][]=$row['table_name'];
		//	mypr($row);
//			  echo $row['table_name']."<br />";
		}
		
		
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}else{
			return $table;
			}
}
function sql_show_table($table){
	global $mssql;
	$params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	//$sql = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='dbo' AND TABLE_NAME='transaction';";
//	$sql = "select * FROM ".$table;
	$sql = 'SELECT * FROM "'.$table.'"';

	$stmt = sqlsrv_query( $mssql, $sql,$params,$options);
	$table_data['row'] = sqlsrv_num_rows( $stmt );
	if($table_data['row']>0){
		if($stmt != False){
			while($row = sqlsrv_fetch_Array($stmt,SQLSRV_FETCH_ASSOC)){
				$table_data['data'][]=$row;
	//                $email_Con = $row['Email'];
	  //              $psw_Con = $row['Senha'];
				}
			return $table_data;
		}else{
			echo "Something Happen in sql_show_table()!";
		}
	}else{
		$table_data['data']=array();
		}
	
	}
function list_tables(){
	global $sqli,$db;
	$sql="SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'MySqlDB'";
	//	$sql = "select table_name from information_schema.tables";
		$stmt = $sqli->query($sql);
		//$stmt = ( $conn, $sql, $params, $options);
//		$row_count = sqlsrv_num_rows($stmt);
//		echo $row_count;

		$row_count = $stmt->num_rows;
		   
	   $table['row']= $row_count;
		while( $row = $stmt->fetch_assoc()) {
			$table['table'][]=$row['TABLE_NAME'];
//			mypr($row);
//			  echo $row['table_name']."<br />";
		}
		//exit;
		
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}else{
			return $table;
			}
}
function show_table($table){
	global $sqli;
	$sql = "select * FROM `".$table."`";
	$stmt = $sqli->query($sql);
	$table_data['row'] = $stmt->num_rows;
		if($stmt != False){
			while($row = $stmt->fetch_assoc()){
			//	mypr($row);
				$table_data['data'][]=$row;
	//                $email_Con = $row['Email'];
	  //              $psw_Con = $row['Senha'];
				}
			return $table_data;
		}else{
			echo "Something Happen in show_table()!";
		}
	
	}
function select_mssql($data,$id){
	global $mssql;
	$params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$sql = "SELECT * FROM ".'"'."".$data['mstable']."".'"'." where ".$data['mstable_id']."='".$id."'";
//	echo $sql;
	$stmt = sqlsrv_query( $mssql, $sql,$params,$options);
	$table_data['row'] = sqlsrv_num_rows($stmt);
	if($table_data['row']>0){
			while($row = sqlsrv_fetch_Array($stmt,SQLSRV_FETCH_ASSOC)){
				$table_d=$row;
	//                $email_Con = $row['Email'];
	  //              $psw_Con = $row['Senha'];
				}
			return $table_d;
	}else{
		$table_data['data']=array();
		}
	
	}
function insert_mssql($data,$content){
	global $mssql;
	$params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	//INSERT INTO dbo.customer	(party_id,name)	VALUES ('34','bandish');
	

	$sql = "INSERT INTO dbo.".$data['mstable']."(id, name)
VALUES((SELECT ISNULL(MAX(id)+1,0) FROM dbo.".$data['mstable']." WITH(SERIALIZABLE, UPDLOCK)), '".$content['name']."')";
//echo $sql;
            if (!sqlsrv_query($mssql, $sql))
                 {
            die('Error: ' . mypr(sqlsrv_errors()));
                 }
            //echo "1 record added";
	
	//$stmt = sqlsrv_query( $mssql, $sql,$params,$options);
	}
function delete_mssql($data,$id){
	global $mssql;
//	echo $id;
	$sql = "DELETE FROM dbo.".$data['mstable']." WHERE  id='".$id."'";
	
//echo $sql;
//exit;
            if (!sqlsrv_query($mssql, $sql))
                 {
            die('Error: ' . mypr(sqlsrv_errors()));
                 }
	//exit;
	}
function select_mysql($data,$id){
	global $sqli;
	$sql = "SELECT * FROM ".$data['mytable']." where id = '".$id."'";
	//echo $sql;
	$result = $sqli->query($sql);
		if ($result->num_rows > 0) {
		// output data of each row
		$row = $result->fetch_assoc();
		return $row;
		}
	}
function insert_mysql($data,$content){
	global $sqli;
	//mypr($content);
	$sql = "INSERT INTO `".$data['mytable']."` (`id`, `name`) VALUES (NULL, '".$content['name']."')";
	//echo $sql; 
	$sqli->query($sql);
	}
function delete_mysql($data,$id){
	global $sqli;
	$sql = "DELETE FROM ".$data['mytable']." where id='".$id."'";
	//echo $sql;
	$sqli->query($sql);
	}
function exe_query_ver1($data){
	//mypr($data);
	foreach($data['msrow'] as $id){
//		echo $id;
		$selected_data = select_mssql($data,$id);
		insert_mysql($data,$selected_data);
		delete_mssql($data,$id);
		}
	
	//mypr($selected_data);
	
	}
function exe_query_ver2($data){
//	mypr($data);
		foreach($data['myrow'] as $id){
//			echo $id;
			$selected_data = select_mysql($data,$id);
//			mypr($selected_data);
			insert_mssql($data,$selected_data);
			delete_mysql($data,$id);
			}
	}

?>