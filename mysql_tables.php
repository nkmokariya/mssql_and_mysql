<?php
include('config.php');
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
	<table class="w3-table w3-striped w3-border">
    	<tr class="w3-blue">
        <?php
		foreach ($table_list['table'] as $table){
			echo '<td><a href="?table='.$table.'" >'.$table.'</a></td>';
			}
		 ?>
        </tr>
	</table>
    <table class="w3-table w3-striped w3-border">
    <tr><?php
	if(isset($current_table['data'])){
	foreach($current_table['data']['0'] as $key=>$data){
		//echo $key;
		echo '<th>'.$key.'</th>';
		}}
    ?></tr>
  
    <?php
	if(isset($current_table['data'])){
	foreach($current_table['data'] as $data){
		echo '<tr>';
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
		}}else{echo '<tr><td> No Data Available</td></tr>';}
	 ?>
    </table>
</body>