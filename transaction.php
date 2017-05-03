<?php
//phpinfo();
// Connect to MSSQL
//$link = sqlsrv_connect($server);
include("config.php");
if(isset($_POST['data'])){
//	mypr($_POST['data']);
	$errors = '';
	$post_data = $_POST['data'];
	if($post_data['mssql'] == 'mstomy'){
		if(isset($post_data['msrow'])){
//			echo 'row available</br>';
			exe_query_ver1($post_data);
			}else{
				$errors[] = 'No data selected in <b>MSSQL</b> Table <b>'.$post_data['mstable'].'</b>';
				}
//		echo 'ms to my ';
		}elseif($post_data['mssql'] == 'mytoms'){
			if(isset($post_data['myrow'])){
//				echo 'row available</br>';
				exe_query_ver2($post_data);
				}else{
					$errors[] = 'No data selected in <b>MySQL</b> Table <b>'.$post_data['mytable'].'</b>';
					}
//			echo 'my to ms';
			}
	
	}
$table_list = list_tables();
if(isset($_GET['table'])){
	echo 'GET';
	$current_table=show_table($_GET['table']);
//	exit;
	
	}else{
	//	mypr($table_list['table']);
		$current_table=show_table($table_list['table'][0]);
		}
//mypr($table_list);
//mypr(show_table($table_list['table'][0]));

?>
<body>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<?php include('nav.php'); ?>


<h1 style="text-align:center;">MY-SQL Database Tables</h1>
<h5>
<?php 
if(isset($errors)&& sizeof($errors)>0){
	mypr($errors);
	
	//foreach($errors as $e){
//		echo '<p style="color:red;">'.$e.'</p>';
//		}
	}

?>
</h5>
    <?php
		foreach ($table_list['table'] as $table){
	
	 ?>
<div class="w3-cell-row">    
<div class="w3-col s5">
<form method="post">
	<table class="w3-table w3-striped w3-border">
    	<tr class="w3-blue">
        <?php 		echo '<td><a href="?table='.$table.'" >'.$table.'</a></td>'; ?>
        <input type="hidden" name="data[mytable]" value="<?php echo $table; ?>">
        </tr>
	</table>
    <table class="w3-table w3-striped w3-border">
    <tr><th></th><?php
	if(isset($current_table['data'])){
	foreach($current_table['data']['0'] as $key=>$data){
		//echo $key;
		echo '<th>'.$key.'</th>';
		}}
    ?></tr>
    
  
    <?php
	$table_now = show_table($table);
	if(isset($table_now['data'])){
	foreach($table_now['data'] as $data){
		echo '<tr><td><input value="'.$data['id'].'" name="data[myrow][]" type="checkbox"></td>';
		foreach ($data as $d){
			if(is_object($d)){
				echo '<td>';
				mypr($d);
				echo '</td>';
				}else{
				echo '<td>'.$d.'</td>';
				}
			}
//		mypr($data);
		echo '</tr>';
//		echo '<td>'.$data[''].'</td><td>'..'</td>';
		}}else{
			echo '<tr><td style="text-align:center;"> No Data Available</td></tr>';
			}
	 ?>
    </table>
    </div>   
    <div class="w3-col s1">
    <table style="margin-top:50px;">
    	<tr><td> <button name="data[mssql]" value="mstomy"> < </button></td></tr>
        <tr><td><button name="data[mssql]" value="mytoms"> > </button></td></tr>
    </table>
    </div>
    <div class="w3-col s5">
    <?php 
	if($table =='customer'){
	//	echo 'customer';
		$sql_table = sql_show_table('customer');
		$sql_table_name = 'customer';
		$sql_table_id = 'id';
//		mypr($sql_table);
		
		}elseif($table=='product'){
			$sql_table = sql_show_table('product');
			$sql_table_name = 'product';
			$sql_table_id = 'id';
	//		echo 'product';
			}
	?>
    <input type="hidden" name="data[mstable]" value="<?php echo $sql_table_name; ?>">
    <input type="hidden" name="data[mstable_id]" value="<?php echo $sql_table_id; ?>">
    <table class="w3-table w3-striped w3-border">
    	<tr class="w3-blue">
        <?php 		echo '<td><a href="?table='.$sql_table_name.'" >'.$sql_table_name.'</a></td>'; ?>
        </tr>
	</table>
    <table class="w3-table w3-striped w3-border">
    <tr><th></th><?php
	if(isset($sql_table['data']['0'])){
	foreach($sql_table['data']['0'] as $key=>$data){
		//echo $key;
		echo '<th>'.$key.'</th>';
		}}else{
			echo "<th><th>";
			}
    ?></tr>
  
    <?php
	if(isset($sql_table['data'])){
	foreach($sql_table['data'] as $data){
		echo '<tr><td><input value="'.$data['id'].'" name="data[msrow][]" type="checkbox"></td>';
		foreach ($data as $d){
			if(is_object($d)){
				echo '<td>';
				mypr($d);
				echo '</td>';
				}else{
				echo '<td>'.$d.'</td>';
				}
			}
//		mypr($data);
		echo '</tr>';
//		echo '<td>'.$data[''].'</td><td>'..'</td>';
		}}else{
			echo '<tr><td colspan="3" style="text-align:center;">No data Available</td></tr>';
			}
	 ?>
    </table>
    </form>
       </div>
    </div>
    <?php } ?>
    
 
</body>