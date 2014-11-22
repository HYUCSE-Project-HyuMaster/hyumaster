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

	require './db_connect.php';

	$querystr=sprintf("INSERT INTO MarkerAddRequest SET Coordinate='%s', Title='%s', %Content='%s', UserID='{$UserID}', UserName='{$UserName}';", $mysql_link->real_escape_string($Coordinate), $mysql_link->real_escape_string($Title), $mysql_link->real_escape_string($Content));
	$result=$mysql_link->query($querystr);
	if(!$result)
	{
		$response=array('result'=>'fail', 'server_message'=>'Database Query Error');
		echo json_encode($response);

		exit;
	}

	$response['result']='success';
	$response['server_message']='마커 등록 요청이 완료되었습니다.';

	$mysql_link->close();
	echo json_encode($response);
?>