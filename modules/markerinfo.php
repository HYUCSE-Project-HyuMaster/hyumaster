<?php
	require './db_connect.php';

	header('Content-Type: application/json');

	$Title=null;
	$UID=null;

	list($Title,$UID)=split("/", $_POST['PostData']);

	$querystr=sprintf("SELECT * FROM Marker WHERE Name='%s' AND UID='%s';", $mysql_link->real_escape_string($Title), $mysql_link->real_escape_string($UID));
	$result=$mysql_link->query($querystr);
	if(!$result)
	{
		$response=array('result'=>'fail', 'server_message'=>'Database Query Error');
		echo json_encode($response);

		exit;
	}

	$response['result']='success';

	$result->data_seek(0);
	$result_data=$result->fetch_array(MYSQLI_ASSOC);
	
	$response['Name']=$result_data['Name'];
	$response['Content']=$result_data['Content'];
	$response['Property']=$result_data['Property'];

	if($response['Property']=='initial')
	{
		$response['Time']='-';
	}
	else
	{
		$response['Time']=$result_data['RequestTime'];
	}
	
	$mysql_link->close();
	echo json_encode($response);
?>