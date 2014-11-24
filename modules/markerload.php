<?php
	require './db_connect.php';

	header('Content-Type: application/json');

	$querystr=sprintf("SELECT * FROM Marker;");
	$result=$mysql_link->query($querystr);
	if(!$result)
	{
		$response=array('result'=>'fail', 'server_message'=>'Database Query Error');
		echo json_encode($response);

		exit;
	}

	$i=0;
	$count=0;
	for($i=1;$i<=$result->num_rows;$i++)
	{
		$result->data_seek($i-1);
		$result_data=$result->fetch_array(MYSQLI_ASSOC);

		if($result_data['Property']=='talk' && strtotime($result_data['RequestTime'])+86400<time())
		{
			continue;
		}

		if($result_data['Property']=='inform' && strtotime($result_data['RequestTime'])+86400*5<time())
		{
			continue;
		}

		if($result_data['Property']=='warning' && strtotime($result_data['RequestTime'])+86400*7<time())
		{
			continue;
		}

		$response[$count]['Name']=$result_data['Name']."/".$result_data['UID'];
		$response[$count]['latitude']=$result_data['latitude'];
		$response[$count]['longitude']=$result_data['longitude'];
		$response[$count]['Property']=$result_data['Property'];
		$count++;
	}

	$mysql_link->close();
	$response['result']='success';
	echo json_encode($response);
?>