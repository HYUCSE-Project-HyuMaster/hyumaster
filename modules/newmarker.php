<?php
	require('./initialize.php');

	header('Content-Type: application/json');

	if(!isset($_SESSION['login_state']) || $_SESSION['login_state']==false)
	{
		$response=array('result'=>'fail', 'server_message'=>'UnAuthorized');
		echo json_encode($response);

		exit;
	}

	$Coordinate=$_POST['Coordinate'];
	$Title=$_POST['Title'];
	$Content=$_POST['Content'];
	$UserID=$_SESSION['UserID'];
	$UserName=$_SESSION['UserName'];

	$Content=str_replace('<script>', '', $Content);
	$Content=str_replace('</script>', '', $Content);
	$Content=str_replace('<script', '', $Content);
	$Content=str_replace('/script>', '', $Content);

	if($Title=='' || $Content=='')
	{
		$response=array('result'=>'fail', 'server_message'=>'마커 이름 또는 마커 내용이 비어있습니다.');
		echo json_encode($response);

		exit;
	}

	$longitude=null;
	$latitude=null;

	list($longitude,$latitude)=split(",", $Coordinate);

	require './db_connect.php';

	$querystr=sprintf("INSERT INTO Marker SET latitude='%s', longitude='%s', Name='%s', Property='useradd', Content='%s', UserID='%s', UserName='%s';",
		$mysql_link->real_escape_string($latitude),
		$mysql_link->real_escape_string($longitude),
		$mysql_link->real_escape_string($Title),
		$mysql_link->real_escape_string($Content),
		$mysql_link->real_escape_string($UserID),
		$mysql_link->real_escape_string($UserName)
	);

	$result=$mysql_link->query($querystr);
	if(!$result)
	{
		$response=array('result'=>'fail', 'server_message'=>'Database Query Error');
		echo json_encode($response);

		exit;
	}

	$response['result']='success';
	$response['server_message']='마커가 등록되었습니다.';

	$mysql_link->close();
	echo json_encode($response);
?>