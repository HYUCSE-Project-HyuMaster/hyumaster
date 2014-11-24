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
	$Property=$_POST['Property'];
	$UserID=$_SESSION['UserID'];
	$UserName=$_SESSION['UserName'];

	$Content=strip_tags($Content);

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

	$querystr=sprintf("INSERT INTO Marker SET latitude='%s', longitude='%s', Name='%s', Property='%s', Content='%s', UserID='%s', UserName='%s';",
		$mysql_link->real_escape_string($latitude),
		$mysql_link->real_escape_string($longitude),
		$mysql_link->real_escape_string($Title),
		$mysql_link->real_escape_string($Property),
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

/*
<h4><strong>학생회실 정보</strong></h4>
-<br>
<br>

<h4><strong>매점/문구점 정보</strong></h4>
-<br>
<br>

<h4><strong>도서관/열람실 정보 및 개방시간</strong></h4>
의학학술정보관, 오전 9시 ~ 오후 10시<br>
<br>

<h4><strong>식당 정보</strong></h4>
-<br>
<br>

<h4><strong>은행/ATM 정보</strong></h4>
-<br>
<br>

<h4><strong>인쇄실/복사실 정보</strong></h4>
건물 3층<br>
<br>

<h4><strong>샤워실 정보</strong></h4>
-<br>
<br>

<h4><strong>여자휴게실 정보</strong></h4>
제2 의학관 1층<br>
<br>

<h4><strong>팀플 공간 정보</strong></h4>
-<br>
<br>

<h4><strong>공연시설 정보</strong></h4>
-<br>
<br>
*/
?>