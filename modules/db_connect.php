<?php
	$DB_address="127.0.0.1";
	$DB_user="HyuMaster";
	$DB_pass="vKycNwpdnESMXmVn";

	$mysql_link=new mysqli($DB_address, $DB_user, $DB_pass);
	$mysql_link->set_charset('utf8');
	if($mysql_link->connect_error)
	{
		$response=array('result'=>'fail', 'server_message'=>'Database Connection Error');
		echo json_encode($response);

		session_unset();
		session_destroy();

		exit;
	}

	if(!$mysql_link->select_db("HyuMaster"))
	{
		$response=array('result'=>'fail', 'server_message'=>'Database Connection Error');
		echo json_encode($response);

		session_unset();
		session_destroy();

		exit;
	}
?>