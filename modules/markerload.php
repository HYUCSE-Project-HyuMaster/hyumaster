<?php
	require './db_connect.php';

	$querystr=sprintf("SELECT * FROM Marker;");
	$result=$mysql_link->query($querystr);
	if(!$result)
	{
		$response=array('result'=>'fail', 'server_message'=>'Database Query Error');
		echo json_encode($response);

		exit;
	}
	
	$response['result']='success';

	$i=0;
	for($i=1;$i<=$result->num_rows;$i++)
	{
		$result->data_seek($i-1);
		$result_data=$result->fetch_array(MYSQLI_ASSOC);

		$response[$i]['Name']=$result_data['Name'];
		$response[$i]['latitude']=$result_data['latitude'];
		$response[$i]['longitude']=$result_data['longitude'];
		$response[$i]['Property']=$result_data['Property'];
	}

	$mysql_link->close();
	echo json_encode($response);
?>